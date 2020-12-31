<?php

namespace backend\controllers;

use Yii;
use backend\models\MFLFacilityRatings;
use backend\models\MFLFacilityRatingsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use backend\models\AuditTrail;
use backend\models\User;

/**
 * FacilityRatingsController implements the CRUD actions for MFLFacilityRatings model.
 */
class FacilityRatingsController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'delete',],
                'rules' => [
                    [
                        'actions' => ['index', 'delete'],
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
     * Lists all MFLFacilityRatings models.
     * @return mixed
     */
    public function actionIndex() {
        if (User::userIsAllowedTo('View facility ratings')) {
            $searchModel = new MFLFacilityRatingsSearch();
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
     * Displays a single MFLFacilityRatings model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found

      public function actionView($id) {
      return $this->render('view', [
      'model' => $this->findModel($id),
      ]);
      } */
    /**
     * Creates a new MFLFacilityRatings model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed

      public function actionCreate() {
      $model = new MFLFacilityRatings();

      if ($model->load(Yii::$app->request->post()) && $model->save()) {
      return $this->redirect(['view', 'id' => $model->id]);
      }

      return $this->render('create', [
      'model' => $model,
      ]);
      } */
    /**
     * Updates an existing MFLFacilityRatings model.
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
     * Deletes an existing MFLFacilityRatings model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id) {
        if (User::userIsAllowedTo('Remove facility ratings')) {
            $model = $this->findModel($id);
            $name = $model->rating;
            try {
                if ($model->delete()) {
                    $audit = new AuditTrail();
                    $audit->user = Yii::$app->user->id;
                    $audit->action = "Removed Facility rating  from the system.";
                    $audit->ip_address = Yii::$app->request->getUserIP();
                    $audit->user_agent = Yii::$app->request->getUserAgent();
                    $audit->save();
                    Yii::$app->session->setFlash('success', "Facility rating was successfully removed.");
                } else {
                    Yii::$app->session->setFlash('error', "Facility rating  could not be removed. Please try again!");
                }
            } catch (yii\db\IntegrityException $ex) {
                Yii::$app->session->setFlash('error', "Facility rating could not be removed. Please try again!");
            }

            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Finds the MFLFacilityRatings model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return MFLFacilityRatings the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = MFLFacilityRatings::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
