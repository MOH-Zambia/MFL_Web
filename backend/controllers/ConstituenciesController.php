<?php

namespace backend\controllers;

use Yii;
use backend\models\Constituency;
use backend\models\ConstituencySearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use backend\models\AuditTrail;
use backend\models\User;

/**
 * ConstituenciesController implements the CRUD actions for Constituency model.
 */
class ConstituenciesController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'delete', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'view'],
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
     * Lists all Constituency models.
     * @return mixed
     */
    public function actionIndex() {
        if (User::userIsAllowedTo('Manage constituencies')) {
            $model = new Constituency();
            $searchModel = new ConstituencySearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);
            if (Yii::$app->request->post('hasEditable')) {
                $Id = Yii::$app->request->post('editableKey');
                $model = Constituency::findOne($Id);
                $out = Json::encode(['output' => '', 'message' => '']);
                $posted = current($_POST['Constituency']);
                $post = ['Constituency' => $posted];
                $old = $model->name;
                $old_population = $model->population;
                $old_pop_density = $model->pop_density;
                $old_area_sq_km = $model->area_sq_km;
                $old_district = $model->district_id;
                $action = "";

                if ($model->load($post)) {
                    if ($old != $model->name) {
                        $action = "updated Constituency name from $old to " . $model->name;
                    }
                    if ($old_population != $model->population) {
                        $action = "updated " . $model->name . " Constituency population from $old_population to " . $model->population;
                    }
                    if ($old_pop_density != $model->pop_density) {
                        $action = "updated " . $model->name . " Constituency population density from $old_pop_density to " . $model->pop_density;
                    }
                    if ($old_area_sq_km != $model->area_sq_km) {
                        $action = "updated " . $model->name . " Constituency area from $old_area_sq_km sq kilometer to " . $model->area_sq_km . " sq kilometer";
                    }
                    if ($old_district_type != $model->district_type_id) {
                        $action = "updated " . $model->name . " Constituency district from " . \backend\models\Districts::findOne($old_district)->name . " to " . \backend\models\Districts::findOne($model->district_id)->name;
                    }

                    if (!empty($action)) {
                        $audit = new AuditTrail();
                        $audit->user = Yii::$app->user->id;
                        $audit->action = $action;
                        $audit->ip_address = Yii::$app->request->getUserIP();
                        $audit->user_agent = Yii::$app->request->getUserAgent();
                        $audit->save();
                    }

                    $message = '';
                    if (!$model->save()) {
                        foreach ($model->getErrors() as $error) {
                            $message .= $error[0];
                        }
                        $output = $message;
                    }
                    $output = '';
                    $out = Json::encode(['output' => $output, 'message' => $message]);
                }
                return $out;
            }
            return $this->render('index', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Displays a single Constituency model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (User::userIsAllowedTo('Manage constituencies')) {
            $model = Constituency::find()
                            ->select(['id', 'name', 'population', 'pop_density', 'area_sq_km', 'ST_AsGeoJSON(geom) as geom', 'district_id'])
                            ->where(["id" => $id])->one();
            return $this->render('view', [
                        'model' => $model,
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Creates a new Constituency model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */

    public function actionCreate() {
        if (User::userIsAllowedTo('Manage constituencies')) {
            $model = new Constituency();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $audit = new AuditTrail();
                    $audit->user = Yii::$app->user->id;
                    $audit->action = "Added Constituency " . $model->name;
                    $audit->ip_address = Yii::$app->request->getUserIP();
                    $audit->user_agent = Yii::$app->request->getUserAgent();
                    $audit->save();
                    Yii::$app->session->setFlash('success', 'Constituency ' . $model->name . ' was successfully added.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while adding Constituency ' . $model->name);
                }
                return $this->redirect(['index']);
            }
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }


    /**
     * Deletes an existing Constituency model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
  public function actionDelete($id) {
        if (User::userIsAllowedTo('Remove constituencies')) {
            $model = $this->findModel($id);
            $name = $model->name;
            if ($model->delete()) {
                $audit = new AuditTrail();
                $audit->user = Yii::$app->user->id;
                $audit->action = "Removed Constituency $name from the system.";
                $audit->ip_address = Yii::$app->request->getUserIP();
                $audit->user_agent = Yii::$app->request->getUserAgent();
                $audit->save();
                Yii::$app->session->setFlash('success', "Constituency $name was successfully removed.");
            } else {
                Yii::$app->session->setFlash('error', "Constituency $name could not be removed. Please try again!");
            }

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Finds the Constituency model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Constituency the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Constituency::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
