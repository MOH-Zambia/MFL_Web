<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\LoginForm */

use yii\helpers\Html;
use kartik\form\ActiveForm;

$this->title = 'User login';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-5">
    <div class="card card-primary card-outline">
       
        <div class="card-body">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php
            $form = ActiveForm::begin([
                        // 'id' => 'login-form',
                        // 'layout' => 'horizontal',
                        'fieldConfig' => [
                        //'template' => "<div style=\"text-align:center;margin-bottom:0px;\" class=\"col-lg-12\">{input}</div>\n<div class=\"col-lg-8\">{error}</div>",
                        //'labelOptions' => ['class' => 'col-lg-1 control-label'],
                        ],
            ]);
            ?>
            <div class="form-group mb-3">
                <?=
                $form->field($model, 'email', [
                    'addon' => ['prepend' => ['content' => ' <span class="fas fa-envelope"></span>']]
                ])->textInput(['class' => 'form-control ', 'autocorrect' => 'off', 'autocapitalize' => 'none', 'autofocus' => false, 'placeholder' => 'Email',])->label(false);
                ?>
                <!--<div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                    </div>
                </div>-->

            </div>
            <div class="form-group">
                <?=
                $form->field($model, 'password', [
                    'addon' => ['prepend' => ['content' => ' <span class="fas fa-lock"></span>']]
                ])->passwordInput(['class' => 'form-control ', 'autocorrect' => 'off', 'autocapitalize' => 'none',
                    'autofocus' => false, 'placeholder' => 'Password',])->label(false);
                ?>

                <!--<div class="input-group-append">
                    <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                    </div>
                </div>-->
            </div>

            <!-- /.col -->
            <div class="form-group">
                <?= Html::submitButton('Sign in', ['class' => 'btn btn-block btn-primary btn-sm', 'name' => 'login-button']) ?>

            </div>
            <div class="mb-1" style="color:#999;margin:1em 0">

                Forgot your password? <?= Html::a('reset it here', ['site/request-password-reset']) ?>

            </div>
            <!-- /.col -->

            <?php ActiveForm::end(); ?>
        </div>
    </div>
</div>
<div class="col-md-4">

</div>

