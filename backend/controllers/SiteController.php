<?php

namespace backend\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use backend\models\LoginForm;
use backend\models\PasswordResetRequestForm;
use backend\models\ResetPasswordForm;
use yii\helpers\Json;
use backend\models\User;
use backend\models\UserSearch;
use common\models\Role;
use backend\models\AuditTrail;

class SiteController extends Controller {

    /**
     * {@inheritdoc}
     */
    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'change-password'],
                'rules' => [
                    [
                        'actions' => ['login', 'index'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'change-password'],
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
     * @return string
     */
    public function actionIndex() {
        //  $this->layout = 'login';
        return $this->redirect(['login']);
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin() {
        //$session = Yii::$app->session;
        //$session->destroy();
         $this->layout = 'main_1';
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            $rightsArray = \common\models\RightAllocation::getRights(Yii::$app->getUser()->identity->role);
            $rights = \implode(",", $rightsArray);
            $session = Yii::$app->session;
            $session->set('role', Role::findOne(['id' => Yii::$app->getUser()->identity->role])->role);
            $session->set('user', $user->getFullName());
            $session->set('rights', $rights);
            $session->set('created_at', $user->created_at);
            return $this->redirect(['home/home']);
        }
        $model->password = '';
        return $this->render('login', [
                    'model' => $model,
        ]);
    }

    public function actionChangePassword() {
        $model = new \backend\models\ResetPasswordForm_1();
        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            $audit = new AuditTrail();
            $audit->user = Yii::$app->user->id;
            $audit->action = "Changed account password";
            $audit->ip_address = Yii::$app->request->getUserIP();
            $audit->user_agent = Yii::$app->request->getUserAgent();
            $audit->save();
            Yii::$app->user->logout();
            Yii::$app->session->setFlash('success', 'Password was successfully changed. Sign in with your new password');
            return $this->goHome();
        }
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     * @throws \yii\base\Exception
     */
    public function actionRequestPasswordReset() {

        $model = new PasswordResetRequestForm();
        if (Yii::$app->request->isAjax) {
            $model->load(Yii::$app->request->post());
            return Json::encode(\yii\widgets\ActiveForm::validate($model));
        }
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');
                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }
        $this->layout = 'main_1';
        return $this->render('requestPasswordResetToken', [
                    'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     * @throws \yii\base\Exception
     */
    public function actionResetPassword1($token) {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidArgumentException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }
        $this->layout = 'main_1';
        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    public function actionSetPassword($token) {

        if (empty($token) || !is_string($token)) {
            Yii::$app->session->setFlash('error', 'Your account activation token has expired. Please contact the system administrator for the link to be resent!.');
            //$model = new LoginForm();
            return $this->goHome();
        }
        $_user = User::findByPasswordResetTokenInactiveAccount($token);
        if (!$_user) {
            Yii::$app->session->setFlash('error', 'Your account activation token has expired. Please contact the system administrator for the link to be resent!.');
            return $this->goHome();
        }
        try {
            $this->layout = 'main_1';
            $model = new \backend\models\SetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Account was successfully activated. Login into your account!');
            $model = new LoginForm();
            return $this->goHome();
        }

        return $this->render('setPassword', [
                    'model' => $model,
        ]);
    }

    public function actionResetPassword($token) {
        $this->layout = 'main_1';

        if (empty($token) || !is_string($token)) {
            Yii::$app->session->setFlash('error', 'Your token has expired. Please request for a new one again!.');
            return $this->redirect(['request-password-reset']);
        }
        $_user = User::findByPasswordResetToken($token);
        if (!$_user) {
            Yii::$app->session->setFlash('error', 'Your token has expired. Please request for a new one again!.');
            return $this->redirect(['request-password-reset']);
        }

        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            return $this->redirect(['request-password-reset']);
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'Password was successfully reset. Sign in with your new password');
            $model = new LoginForm();
            return $this->goHome();
        }

        return $this->render('resetPassword', [
                    'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout() {
        Yii::$app->user->logout();

        return $this->goHome();
    }

}
