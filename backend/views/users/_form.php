<?php

use yii\helpers\Html;
//use yii\bootstrap4\ActiveForm;
use borales\extensions\phoneInput\PhoneInput;
use kartik\form\ActiveForm;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use common\models\Role;
/* @var $this yii\web\View */
/* @var $model backend\models\User */
/* @var $form yii\widgets\ActiveForm */
?>


<div class="row" style="">

    <div class="col-lg-6">
        <h4>Instructions</h4>
        <ol>
            <li>Select user type you want to add</li>
            <?php
            if (!empty($user_type)) {
                echo '<li>Fields marked with * are required</li>
            <li>Email will be used as login username</li>
            <li>Fill in the fields below to add <b>"' . $user_type . '"</b> type</li>';
            }
            ?>
        </ol>
    </div>
</div>

<?php
$form = ActiveForm::begin(['type' => ActiveForm::TYPE_VERTICAL, 'formConfig' => ['labelSpan' => 3, 'deviceSize' => ActiveForm::SIZE_SMALL]]);

?>
<hr class="dotted short">
<div class="row">
  <?php

        echo '<div class="col-md-6">';

        echo $form->field($model, 'first_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'First name'])->label("First name");
        echo $form->field($model, 'last_name')->textInput(['maxlength' => true, 'class' => "form-control", 'placeholder' => 'Last name'])->label("Last name");
       
        echo $form->field($model, 'email', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'type' => 'email', 'placeholder' => 'email address', 'required' => true])->label("Email");

        echo $form->field($model, 'role')->dropDownList(
                yii\helpers\ArrayHelper::map(Role::find()->asArray()->all(), 'id', 'role'), ['custom' => true, 'maxlength' => true, 'style' => '', 'prompt' => 'Please select role', 'required' => true]
        )->label("Role");

        echo '</div>
        <div class="form-group col-lg-12">';
        echo Html::submitButton('Save', ['class' => 'btn btn-success btn-sm']);
        echo '</div>';

    ?>

</div>
<?php ActiveForm::end(); ?>


