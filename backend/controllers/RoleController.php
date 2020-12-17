<?php

namespace backend\controllers;

use backend\models\User;
use common\models\RightAllocation;
use Throwable;
use Yii;
use yii\helpers\Json;
use common\models\Role;
use common\models\RoleSearch;
use yii\db\StaleObjectException;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use backend\models\AuditTrail;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class RoleController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index', 'create', 'update', 'delete', 'view'],
                'rules' => [
                    [
                        'actions' => ['index', 'create', 'update', 'delete', 'view'],
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
     * Lists all Role models.
     * @return mixed
     */
    public function actionIndex() {
        if (User::userIsAllowedTo('View Roles')) {
            $searchModel = new RoleSearch();
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
     * Displays a single Role model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id) {
        if (User::userIsAllowedTo('View Roles')) {
            return $this->render('view', [
                        'model' => $this->findModel($id)
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Creates a new Role model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate() {
        if (User::userIsAllowedTo('Manage Roles')) {
            $model = new Role();
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }

            $model->created_by = Yii::$app->user->id;
            $model->updated_by = Yii::$app->user->id;
            if ($model->load(Yii::$app->request->post())) {
                $rights = $model->rights;
                /* var_dump(Yii::$app->request->post()['Role']['rights']);
                  foreach (Yii::$app->request->post()['Role']['rights'] as $right) {
                  echo $right;
                  } */
                if ($model->save()) {
                    // var_dump($model->rights);
                    foreach (Yii::$app->request->post()['Role']['rights'] as $right) {
                        $rightAllocation = new RightAllocation();
                        $rightAllocation->role = $model->id;
                        $rightAllocation->right = $right;
                        // $rightAllocation->created_by = Yii::$app->user->id;
                        $rightAllocation->save();
                    }
                    $audit = new AuditTrail();
                    $audit->user = Yii::$app->user->id;
                    $audit->action = "Created role " . $model->role;
                    $audit->ip_address = Yii::$app->request->getUserIP();
                    $audit->user_agent = Yii::$app->request->getUserAgent();
                    $audit->save();
                    Yii::$app->session->setFlash('success', 'Role ' . $model->role . ' was successfully created.');
                    return $this->redirect(['view', 'id' => $model->id]);
                } else {
                    Yii::$app->session->setFlash('error', 'Error occured while creating user role.Please try again!');
                }
            }
            return $this->render('create', ['model' => $model]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Updates an existing Role model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id) {
        if (User::userIsAllowedTo('Manage Roles')) {
            $model = $this->findModel($id);
            if (Yii::$app->request->isAjax) {
                $model->load(Yii::$app->request->post());
                return Json::encode(\yii\widgets\ActiveForm::validate($model));
            }
            $model->rights = RightAllocation::getRights($model->id);
            $array = [];
            foreach ($model->rights as $right => $v) {
                array_push($array, $right);
            }
            $model->rights = $array;
            if ($model->load(Yii::$app->request->post())) {
                //var_dump($model->rights);
                if (!empty($model->rights)) {
                    $model->updated_by = Yii::$app->user->id;
                    if ($model->save()) {
                        $rightAllocation = new RightAllocation();
                        $rightAllocation::deleteAll(['role' => $id]);
                        foreach (Yii::$app->request->post()['Role']['rights'] as $right) {
                            //check if the right was already assigned to this role
                            $rightAllocation = new RightAllocation();
                            $rightAllocation->created_by = Yii::$app->user->id;
                            $rightAllocation->role = $id;
                            // $rightAllocation->id = NULL; //primary key(auto increment id) id
                            $rightAllocation->isNewRecord = true;
                            $rightAllocation->right = $right;
                            //$rightAllocation->created_by = Yii::$app->user->id;
                            $rightAllocation->save();
                        }

                        //check if current user has the role that has just been edited so that we update the permissions instead of user logging out
                        if (Yii::$app->getUser()->identity->role == $model->id) {
                            $rightsArray = \common\models\RightAllocation::getRights(Yii::$app->getUser()->identity->role);
                            $rights = implode(",", $rightsArray);
                            $session = Yii::$app->session;
                            $session->set('rights', $rights);
                        }

                        $audit = new AuditTrail();
                        $audit->user = Yii::$app->user->id;
                        $audit->action = "Updated role " . $model->role;
                        $audit->ip_address = Yii::$app->request->getUserIP();
                        $audit->user_agent = Yii::$app->request->getUserAgent();
                        $audit->save();
                        Yii::$app->session->setFlash('success', 'Role ' . $model->role . ' was successfully updated.');
                        return $this->redirect(['view', 'id' => $model->id]);
                    } else {
                        Yii::$app->session->setFlash('error', 'Error occurred while updating role.Please try again.');
                        return $this->render('update', ['id' => $model->id, 'model' => $model]);
                    }
                } else {
                    Yii::$app->session->setFlash('error', 'You need to select at least one right!');
                    return $this->render('update', ['id' => $model->id, 'model' => $model]);
                }
            }

            return $this->render('update', [
                        'model' => $model
            ]);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Deletes an existing Role model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     * @throws Throwable
     * @throws StaleObjectException
     */
    public function actionDelete($id) {
        if (User::userIsAllowedTo('Manage Roles')) {
            //delete all RightAllocation objects with $id as role
            RightAllocation::deleteAll(['role' => $id]);
            $name = $this->findModel($id)->role;
            if ($this->findModel($id)->delete()) {
                $audit = new AuditTrail();
                $audit->user = Yii::$app->user->id;
                $audit->action = "Removed role " . $name . " from the system";
                $audit->ip_address = Yii::$app->request->getUserIP();
                $audit->user_agent = Yii::$app->request->getUserAgent();
                $audit->save();
                Yii::$app->session->setFlash('success', 'Role ' . $name . ' was successfully deleted.');
            } else {
                Yii::$app->session->setFlash('error', 'Model could not be deleted.');
            }
            return $this->redirect(['index']);
        } else {
            Yii::$app->session->setFlash('error', 'You are not authorised to perform that action.');
            return $this->redirect(['home/home']);
        }
    }

    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Role::findOne($id)) !== null) {
            return $model;
        }
        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
