<?php

namespace backend\controllers;

use Yii;
use backend\models\ValidationRuleOperator;
use backend\models\ValidationRuleOperatorSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use yii\helpers\Json;
use backend\models\AuditTrail;
use backend\models\User;
use yii\db\Expression;

/**
 * ValidationRuleOperatorController implements the CRUD actions for ValidationRuleOperator model.
 */
class ValidationRuleOperatorController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'delete', 'create', 'update'],
                'rules' => [
                    [
                        'actions' => ['index', 'delete', 'create', 'update'],
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
     * Lists all ValidationRuleOperator models.
     * @return mixed
     */
    public function actionIndex() {
        if (User::userIsAllowedTo("Manage validation rule operators") ||
                User::userIsAllowedTo("View validation rule operators")) {
            $model = new ValidationRuleOperator();
            $searchModel = new ValidationRuleOperatorSearch();
            $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

            if (Yii::$app->request->post('hasEditable')) {
                $Id = Yii::$app->request->post('editableKey');
                $model = ValidationRuleOperator::findOne($Id);
                $out = Json::encode(['output' => '', 'message' => '']);
                $posted = current($_POST['ValidationRuleOperator']);
                $post = ['ValidationRuleOperator' => $posted];
                $old = $model->name;
                $old_desc = $model->description;

                if ($model->load($post)) {
                    if ($old != $model->name) {
                        $action = "updated validation rule operator name from $old to " . $model->name;
                    }
                    if ($old_desc != $model->description) {
                        $action = "updated " . $model->name . " validation rule operator description from $old_desc to " . $model->description;
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
     * Displays a single ValidationRuleOperator model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found

      public function actionView($id) {
      return $this->render('view', [
      'model' => $this->findModel($id),
      ]);
      } */

    /**
     * Creates a new ValidationRuleOperator model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (User::userIsAllowedTo("Manage validation rule operators")) {
            $model = new ValidationRuleOperator();

            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }
            if ($model->load(Yii::$app->request->post())) {
                if ($model->save()) {
                    $audit = new AuditTrail();
                    $audit->user = Yii::$app->user->id;
                    $audit->action = "Added validation rule operator: " . $model->name;
                    $audit->ip_address = Yii::$app->request->getUserIP();
                    $audit->user_agent = Yii::$app->request->getUserAgent();
                    $audit->save();
                    Yii::$app->session->setFlash('success', 'Validation rule operator: ' . $model->name . ' was successfully added.');
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while adding validation rule operator: ' . $model->name);
                }
            }
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Updates an existing ValidationRuleOperator model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found

      public function actionUpdate($id) {
      $model = $this->findModel($id);

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('update', [
      'model' => $model,
      ]);
      } */

    /**
     * Deletes an existing ValidationRuleOperator model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::userIsAllowedTo("Manage validation rule operators")) {
            $model = $this->findModel($id);
            $name = $model->name;
            try {
                if ($model->delete()) {
                    $audit = new AuditTrail();
                    $audit->user = Yii::$app->user->id;
                    $audit->action = "Removed validation rule operator: $name from the system.";
                    $audit->ip_address = Yii::$app->request->getUserIP();
                    $audit->user_agent = Yii::$app->request->getUserAgent();
                    $audit->save();
                    Yii::$app->session->setFlash('success', "Validation rule operator: $name was successfully removed.");
                } else {
                    Yii::$app->session->setFlash('error', "Validation rule operator: $name could not be removed. Please try again!");
                }
            } catch (Exception $ex) {
                Yii::$app->session->setFlash('error', "Validation rule operator: $name could not be removed. Please try again!");
            }

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Finds the ValidationRuleOperator model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return ValidationRuleOperator the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = ValidationRuleOperator::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
