<?php

namespace backend\controllers;

use Yii;
use backend\models\DataElements;
use backend\models\DataElementsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use backend\models\AuditTrail;
use backend\models\User;
use yii\db\Expression;
use kartik\mpdf\Pdf;

/**
 * DataElementsController implements the CRUD actions for DataElements model.
 */
class DataElementsController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'delete', 'view', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'view', 'create', 'update'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all DataElements models.
     * @return mixed
     */
    public function actionIndex() {
        if (User::userIsAllowedTo("Manage data elements") ||
                User::userIsAllowedTo("View data elements")) {
            $searchModel = new DataElementsSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Displays a single DataElements model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (User::userIsAllowedTo("Manage data elements") ||
                User::userIsAllowedTo("View data elements")) {
            return $this->render('view', [
                        'model' => $this->findModel($id),
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Creates a new DataElements model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (User::userIsAllowedTo("Manage data elements")) {
            $model = new DataElements();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }
            if ($model->load(Yii::$app->request->post())) {
                $model->created_by = Yii::$app->user->identity->id;
                $model->updated_by = Yii::$app->user->identity->id;
                $model->uid = Yii::$app->security->generateRandomString(11);
                //We check that uid is not in the validation rules/indicator table
                if (!empty(\backend\models\ValidationRules::findOne(['uid' => $model->uid]))) {
                    $model->uid = Yii::$app->security->generateRandomString(11);
                }
                if (!empty(\backend\models\Indicators::findOne(['uid' => $model->uid]))) {
                    $model->uid = Yii::$app->security->generateRandomString(11);
                }

                if ($model->save()) {
                    $audit = new AuditTrail();
                    $audit->user = Yii::$app->user->id;
                    $audit->action = "Added Data element: " . $model->name;
                    $audit->ip_address = Yii::$app->request->getUserIP();
                    $audit->user_agent = Yii::$app->request->getUserAgent();
                    $audit->save();
                    Yii::$app->session->setFlash('success', 'Data element: {' . $model->name . '} was successfully added.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while adding data element: ' . $model->name);
                }
            }

            return $this->render('create', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Updates an existing DataElements model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (User::userIsAllowedTo("Manage data elements")) {
            $model = $this->findModel($id);

            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }
            if ($model->load(Yii::$app->request->post())) {
                $model->updated_by = Yii::$app->user->identity->id;
                if ($model->save()) {
                    $audit = new AuditTrail();
                    $audit->user = Yii::$app->user->id;
                    $audit->action = "Updated data element: " . $model->name;
                    $audit->ip_address = Yii::$app->request->getUserIP();
                    $audit->user_agent = Yii::$app->request->getUserAgent();
                    $audit->save();
                    Yii::$app->session->setFlash('success', 'Data element:{' . $model->name . '} was successfully updated.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    $msg="";
                     foreach ($model->getErrors() as $error) {
                        $msg .= $error[0];
                    }
                    Yii::$app->session->setFlash('error', 'Error occured while updating data element: ' . $model->name.".Error::".$msg);
                }
            }

            return $this->render('update', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Deletes an existing DataElements model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::userIsAllowedTo("Remove data elements")) {
            $model = $this->findModel($id);
            if ($model->delete()) {
                $audit = new AuditTrail();
                $audit->user = Yii::$app->user->id;
                $audit->action = "Deleted data element: " . $model->name;
                $audit->ip_address = Yii::$app->request->getUserIP();
                $audit->user_agent = Yii::$app->request->getUserAgent();
                $audit->save();
                Yii::$app->session->setFlash('success', 'Data element:{' . $model->name . '} was successfully removed.');
            } else {
                Yii::$app->session->setFlash('error', 'Error occured while removing data element: ' . $model->name);
            }
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    public function actionDownload($id) {
        $model = $this->findModel($id);
        $filename = "NIDS_" . date("Ymd") . "_DataElements" . ".pdf";
        Yii::$app->response->format = \yii\web\Response::FORMAT_RAW;
        $pdf = new Pdf([
            'mode' => Pdf::MODE_CORE,
            // A4 paper format
            'format' => Pdf::FORMAT_A4,
            // portrait orientation
            'orientation' => Pdf::ORIENT_PORTRAIT,
            // stream to browser inline
            'destination' => Pdf::DEST_BROWSER,
            'content' => $this->renderPartial('download',
                    [
                        'model' => $model,
            ]),
            'options' => [
                'text_input_as_HTML' => true,
                'target' => '_blank',
            // any mpdf options you wish to set
            ],
            'methods' => [
                'SetTitle' => 'Data element',
                //'SetSubject' => 'Generating PDF files via yii2-mpdf extension has never been easy',
                'SetHeader' => ['NIDS/Data elements||' . date("r") . "/MOH online"],
                'SetFooter' => ['|Page {PAGENO}|'],
                'SetAuthor' => 'MOH online',
            ]
        ]);
        $pdf->filename = $filename;
        return $pdf->render();
    }

    /**
     * Finds the DataElements model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return DataElements the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = DataElements::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
