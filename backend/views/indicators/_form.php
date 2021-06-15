<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\Indicators */
/* @var $form yii\widgets\ActiveForm */
$list=['Daily'=>'Daily','Weekly'=>'Weekly','Monthly' => 'Monthly', 'Quarterly' => 'Quarterly','Biannually'=>'Biannually', 'Annually' => 'Annually'];
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

        <?= $form->field($model, 'short_name')->textInput() ?>

        <?= $form->field($model, 'code')->textInput() ?>
        <?=
        $form->field($model, 'definition')->textarea(['rows' => 5, 'placeholder' =>
            'Indicator description'])->label("Description");
        ?>
        <?=
                $form->field($model, 'indicator_group_id')
                ->dropDownList(
                        \backend\models\IndicatorGroup::getList(), ['custom' => true, 'prompt' => 'Select indicator group', 'required' => true]
        );
        ?>
        <?= $form->field($model, 'indicator_type')->textInput() ?>
        <?= $form->field($model, 'level')->textInput() ?>
        <?=
                $form->field($model, 'favorite')
                ->dropDownList(
                        ['true' => 'True', 'false' => 'False'], ['custom' => true, 'prompt' => 'Favorite?', 'required' => true]
        );
        ?>
    </div>
    <div class="col-lg-6">
        <?=
        $form->field($model, 'numerator_description')->textarea(['rows' => 3, 'placeholder' =>
            'Numerator description']);
        ?>
        <?= $form->field($model, 'numerator_formula')->textInput() ?>
        <?=
        $form->field($model, 'denominator_description')->textarea(['rows' => 3, 'placeholder' =>
            'Denominator description']);
        ?>
        <?= $form->field($model, 'denominator_formula')->textInput() ?>
        <?=
                $form->field($model, 'annualized')
                ->dropDownList(
                        $list, ['custom' => true, 'prompt' => 'Annualized?', 'required' => true]
        );
        ?>
        <?=
                $form->field($model, 'frequency')
                ->dropDownList(
                        $list, ['custom' => true, 'prompt' => 'Select frequency', 'required' => true]
        );
        ?>

        <?=
        $form->field($model, 'use_and_context')->textarea(['rows' => 4, 'placeholder' =>
            'Use and Context']);
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save indicator', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>


