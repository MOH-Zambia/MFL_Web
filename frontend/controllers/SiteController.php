<?php

namespace frontend\controllers;

use frontend\models\ResendVerificationEmailForm;
use frontend\models\VerifyEmailForm;
use Yii;
use yii\base\InvalidArgumentException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use yii\data\ActiveDataProvider;

/**
 * Site controller
 */
class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions() {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex() {
        $MFLFacility_model = new \frontend\models\MFLFacility();
        $searchModel = new \frontend\models\MFLFacilitySearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        if (!empty(Yii::$app->request->queryParams['MFLFacility']['province_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacility']['district_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacility']['ownership_id']) ||
                !empty(Yii::$app->request->queryParams['MFLFacility']['name']) ||
                !empty(Yii::$app->request->queryParams['MFLFacility']['facility_type_id'])) {

            if (!empty(Yii::$app->request->queryParams['MFLFacility']['district_id'])) {
                $dataProvider->query->andFilterWhere(['district_id' => Yii::$app->request->queryParams['MFLFacility']['district_id']]);
            }
            if (!empty(Yii::$app->request->queryParams['MFLFacility']['ownership_id'])) {
                $dataProvider->query->andFilterWhere(['ownership_id' => Yii::$app->request->queryParams['MFLFacility']['ownership_id']]);
            }
            if (!empty(Yii::$app->request->queryParams['MFLFacility']['facility_type_id'])) {
                $dataProvider->query->andFilterWhere(['facility_type_id' => Yii::$app->request->queryParams['MFLFacility']['facility_type_id']]);
            }
            if (!empty(Yii::$app->request->queryParams['MFLFacility']['name'])) {
                $dataProvider->query->andFilterWhere(['LIKE', 'name', Yii::$app->request->queryParams['MFLFacility']['name']]);
            }

            if (!empty(Yii::$app->request->queryParams['MFLFacility']['province_id'])) {
                $district_ids = [];
                $districts = \backend\models\Districts::find()->where(['province_id' => Yii::$app->request->queryParams['MFLFacility']['province_id']])->all();
                if (!empty($districts)) {
                    foreach ($districts as $id) {
                        array_push($district_ids, $id['id']);
                    }
                }

                $dataProvider->query->andFilterWhere(['IN', 'district_id', $district_ids]);
            }
        } else {
            if (!empty(Yii::$app->request->queryParams['MFLFacility']) &&
                    Yii::$app->request->queryParams['filter'] == "true") {
                Yii::$app->session->setFlash('error', 'Please pick a filter to filter!');
            }
            $dataProvider = "";
        }
        //var_dump($dataProvider);
        return $this->render('index', [
                    'MFLFacility_model' => $MFLFacility_model,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin() {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            $model->password = '';

            return $this->render('login', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact() {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                        'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout() {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup() {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post()) && $model->signup()) {
            Yii::$app->session->setFlash('success', 'Thank you for registration. Please check your inbox for verification email.');
            return $this->goHome();
        }

        return $this->render('signup', [
                    'model' => $model,
        ]);
    }

    public function actionDistrict() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
           // $selected_id = $_POST['depdrop_params'];
             $selected_id = $_POST['depdrop_all_params']['selected_id']; 
            if ($parents != null) {
                $prov_id = $parents[0];
                $out = \backend\models\Districts::find()
                        ->select(['id', 'name'])
                        ->where(['province_id' => $prov_id])
                        ->asArray()
                        ->all();

                return ['output' => $out, 'selected' => $selected_id];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionConstituency() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $selected_id = $_POST['depdrop_all_params']['selected_id2'];
            if ($parents != null) {
                $dist_id = $parents[0];
                $out = \backend\models\Constituency::find()
                        ->select(['id', 'name'])
                        ->where(['district_id' => $dist_id])
                        ->asArray()
                        ->all();

                return ['output' => $out, 'selected' => $selected_id];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

    public function actionWard() {
        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
        $out = [];
        if (isset($_POST['depdrop_parents'])) {
            $parents = $_POST['depdrop_parents'];
            $selected_id = $_POST['depdrop_all_params']['selected_id3'];
            if ($parents != null) {
                $dist_id = $parents[0];
                $out = \backend\models\Wards::find()
                        ->select(['id', 'name'])
                        ->where(['district_id' => $dist_id])
                        ->asArray()
                        ->all();

                return ['output' => $out, 'selected' => $selected_id];
            }
        }
        return ['output' => '', 'selected' => ''];
    }

}
