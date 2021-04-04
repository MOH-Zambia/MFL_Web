<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\ValidationRules */
/* @var $form yii\widgets\ActiveForm */
?>
<?php $form = ActiveForm::begin(); ?>
<div class="row">
    <div class="col-lg-12">
        <h4>Instructions</h4>
        <ol>
            <li>Fields marked with <span style="color: red;">*</span> are required</li>
        </ol>
    </div>
    <div class="col-lg-6">

        

        <?= $form->field($model, 'name')->textInput() ?>
        <?=
                $form->field($model, 'operator')
                ->dropDownList(
                        \backend\models\ValidationRuleOperator::getList(), ['custom' => true, 'prompt' => 'Select operator', 'required' => true]
        );
        ?>
        <?= $form->field($model, 'left_side')->textInput() ?>

        <?= $form->field($model, 'right_side')->textInput() ?>
    </div>
    <div class="col-lg-6">
        <?=
        $form->field($model, 'description')->textarea(['rows' => 7.5, 'placeholder' =>
            'Validation rule description'])->label("Description ");
        ?>


        <?= $form->field($model, 'type')->textInput() ?>
    </div>
    <div class="form-group col-lg-12">
        <?= Html::submitButton('Save rule', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>


</div>

    <?php ActiveForm::end(); ?>

