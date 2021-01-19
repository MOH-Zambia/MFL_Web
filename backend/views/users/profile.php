<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;
use borales\extensions\phoneInput\PhoneInput;

/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */

$this->title = 'My Profile';
$session = Yii::$app->session;
?>
<div class="row">
    <div class="col-md-3">
        <!-- Profile Image -->
        <div class="card card-primary card-outline">
            <div class="card-body box-profile">
                <div class="text-center">
                    <img src="<?= Url::to('@web/img/icon.png') ?>" class="profile-user-img img-fluid img-circle" alt="User Image">
                </div>

                <h3 class="profile-username text-center"><?= $session['user'] ?></h3>

                <p class="text-muted text-center"><?= $session['role'] ?> </p>

                <span class="name"><strong>Status:</strong> <?php echo $model->status == 1 ? '<i class="fa fa-check success fa-2x" style="color:green;"></i>' : '<i style="color:red;" class="fa fa-times danger fa-2x"></i>'; ?></span>    


            </div>
            <!-- /.card-body -->
        </div>
    </div>
    <!-- /.col -->
    <div class="col-md-9">
        <div class="card card-primary card-outline">
            <div class="card-header p-2">
                <ul class="nav nav-pills">
                    <li class="nav-item"><a class="nav-link active" href="#activity" data-toggle="tab">Details</a></li>
                    <li class="nav-item"><a class="nav-link" href="#timeline" data-toggle="tab">Change password</a></li>
                </ul>
            </div><!-- /.card-header -->
            <div class="card-body">
                <div class="tab-content">
                    <div class="active tab-pane" id="activity">
                        <!-- details -->
                        <h4>Instructions</h4>
                        <ol>
                            <li>Fields marked with * are required</li>
                            <li>Email is used for login hence you will be required to login with new email if you change it</li>
                        </ol>
                        <hr class="dotted short">

                        <?php $form = ActiveForm::begin(); ?>
                        <div class="row">
                            <div class="col-md-6">
                                <?= $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])->label("First name") ?>
                                <?= $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Last name'])->label("Last name") ?>
                                <?php //echo $form->field($model, 'other_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Other names']) ?>
                                <?= $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email address', 'required' => true])->label("Email") ?>

                            </div>
                            <div class="form-group col-lg-12">
                                <?= Html::submitButton('Update profile', ['class' => 'btn btn-primary btn-sm']) ?>
                            </div>
                        </div>
                        <?php ActiveForm::end(); ?>
                        <!-- /.details -->
                    </div>
                    <!-- /.tab-pane -->
                    <div class="tab-pane" id="timeline">
                        <!-- Change password -->
                        <div class="row">

                            <div class="form-group col-lg-12">
                                <h7>Password must meet below requirements</h7>
                                <hr class="dotted" >
                                <ol>
                                    <li>Password should contain at least 10 characters</li>
                                    <li>Password should contain at least one upper case character</li>
                                    <li>Password should contain at least one numeric / digit character</li>
                                    <li>Password should contain at least one special character</li>
                                </ol>
                            </div>
                            <div class="form-group col-lg-12">
                                <div class="form-group col-lg-5">
                                    <?php
                                    $form = ActiveForm::begin([
                                                'action' => ['site/change-password'],
                                    ]);
                                    ?>
                                    <div class="form-group">
                                        <?=
                                        $form->field($model2, 'password', [
                                            'addon' => ['prepend' => ['content' => ' <span class="fas fa-lock"></span>']]
                                        ])->passwordInput(['class' => 'form-control ', 'autocorrect' => 'off', 'autocapitalize' => 'none',
                                            'autofocus' => false, 'placeholder' => 'Password',])->label(false);
                                        ?>
                                    </div>
                                    <div class="form-group">
                                        <?=
                                        $form->field($model2, 'confirm_password', [
                                            'addon' => ['prepend' => ['content' => ' <span class="fas fa-lock"></span>']]
                                        ])->passwordInput(['class' => 'form-control ', 'autocorrect' => 'off', 'autocapitalize' => 'none',
                                            'autofocus' => false, 'placeholder' => 'Confirm Password',])->label(false);
                                        ?>
                                    </div>
                                </div>
                                <div class="form-group col-lg-12">
                                    <?= Html::submitButton('Change', ['maxlength' => false, 'style' => 'width:150px;', 'class' => 'btn btn-primary btn-sm', 'name' => 'login-button']) ?>
                                </div>
                                <?php ActiveForm::end(); ?>
                            </div>
                        </div>
                        <!--/. Change password -->
                    </div>

                    <!-- /.tab-pane -->
                </div>
                <!-- /.tab-content -->
            </div><!-- /.card-body -->
        </div>
        <!-- /.nav-tabs-custom -->
    </div>
</div>
