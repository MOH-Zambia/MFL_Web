

<?php
/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model backend\models\LoginForm */

use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
//use kartik\form\ActiveField;
use kartik\form\ActiveForm;

$this->title = 'Password reset request';
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="col-md-5">
    <div class="card card-primary card-outline">
        
        <div class="card-body ">
            <p>Please fill out your email. A link to reset password will be sent there.</p>

            <?php
            $form = ActiveForm::begin([
            ]);
            ?>
            <?=
            $form->field($model, 'email', ['enableAjaxValidation' => true,
                'addon' => ['prepend' => ['content' => ' <span class="fas fa-envelope"></span>']]
            ])->textInput(['autofocus' => false, 'placeholder' => 'Enter email',])->label(false);
            ?>


            <div class="form-group">
                <?= Html::submitButton('Request', ['class' => 'btn btn-block btn-primary btn-sm']) ?>
            </div>

            <?php ActiveForm::end(); ?>
            <div style="color:#999;margin:1em 0">
                <?= Html::a('Back to Login', ['site/login']) ?>
            </div>
        </div>
    </div>
</div>


