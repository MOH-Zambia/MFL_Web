<?php

use common\models\Right;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model common\models\Role */
/* @var $form yii\widgets\ActiveForm */
?>



<?php
$form = ActiveForm::begin([
        ]);
?>
<div class="form-group col-lg-6">
    <div class="form-group field-role-role">
        <div class="form-group">
            <?=
            $form->field($model, 'role', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' => 'Role name', 'class' => 'form-control', 'required' => true]);
            ?>
        </div>
    </div>
</div>
<div class="form-group col-lg-12">
    <div class="form-group field-role-rights">
        <label for="role-rights" class="control-label">Permissions<span style="color: red;" class="required"> *</span></label>
        <?=
        $form->field($model, 'rights')->checkboxList(ArrayHelper::map(\common\models\Right::getAllRights(), 'right', 'right'), [
            'inline'=>true,
            'item' => function($index, $label, $name, $checked, $value) {
                $checked = $checked ? 'checked' : '';
                return "<label style='font-weight:normal;' class='bt-df-checkbox col-md-3' > <input type='checkbox' {$checked} name='{$name}' value='{$value}'> {$label} </label>";
            }
            , 'separator' => ' ', 'required' => true])->label(false)
        ?>
    </div>
</div>
<div class="form-group col-lg-12">
    <?= Html::submitButton('Save', ['class' => 'btn btn-primary btn-sm']) ?>
</div>

<?php ActiveForm::end(); ?>

