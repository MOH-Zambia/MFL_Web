<?php

use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model backend\models\DataElements */
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
        <?=
                $form->field($model, 'element_group_id')
                ->dropDownList(
                        \backend\models\DataElementGroup::getList(), ['custom' => true, 'prompt' => 'Select element group', 'required' => true]
        );
        ?>

        <?= $form->field($model, 'name')->textInput() ?>

        <?= $form->field($model, 'short_name')->textInput() ?>

        <?= $form->field($model, 'code')->textInput() ?>
        <?=
        $form->field($model, 'definition')->textarea(['rows' => 3, 'placeholder' =>
            'Data element description'])->label("Definition");
        ?>
        <?=
                $form->field($model, 'aggregation_type')
                ->dropDownList(
                        [
                            'SUM' => 'SUM',
                            'COUNT' => 'COUNT',
                            'DISTINCT COUNT' => 'DISTINCT COUNT',
                            'MIN/MAX' => 'MIN/MAX',
                            'AVERAGE' => 'AVERAGE',
                            'VECTOR' => 'VECTOR',
                        ], ['custom' => true, 'prompt' => 'Select Aggregation type', 'required' => true]
        );
        ?>
        <?=
                $form->field($model, 'domain_type')
                ->dropDownList(
                        [
                            'AGGREGATE' => 'AGGREGATE',
                            'COLLECTIONS' => 'COLLECTIONS',
                        ], ['custom' => true, 'prompt' => 'Select domain type', 'required' => true]
        );
        ?>
        <?=
        $form->field($model, 'definition_extended')->textarea(['rows' => 3, 'placeholder' =>
            'Enter extended definition'])->label("Definition extended");
        ?>
        <?=
        $form->field($model, 'use_and_context')->textarea(['rows' => 4, 'placeholder' =>
            'Enter Use and Context'])->label("Use and Context");
        ?>
    </div>
    <div class="col-lg-6">
        <?=
                $form->field($model, 'favorite')
                ->dropDownList(
                        ['true' => 'True', 'false' => 'False'], ['custom' => true, 'prompt' => 'Favorite?', 'required' => true]
        );
        ?>
        <?=
        $form->field($model, 'inclusions')->textarea(['rows' => 3, 'placeholder' =>
            'Enter inclusions'])->label("Inclusions");
        ?>
        <?=
        $form->field($model, 'exclusions')->textarea(['rows' => 4, 'placeholder' =>
            'Enter exclusions'])->label("Exclusions");
        ?>
        <?= $form->field($model, 'tools')->textInput() ?>

        <?=
                $form->field($model, 'keep_zero_values')
                ->dropDownList(
                        ['true' => 'Yes', 'false' => 'No'], ['custom' => true, 'prompt' => 'Keep zero values?', 'required' => true]
        );
        ?>
        <?=
                $form->field($model, 'zeroissignificant')
                ->dropDownList(
                        ['true' => 'Yes', 'false' => 'No'], ['custom' => true, 'prompt' => 'Zero is significant?', 'required' => true]
        );
        ?>
        <?= $form->field($model, 'collected_by')->textInput() ?>

        <?= $form->field($model, 'collection_point')->textInput() ?>
        <?=
        $form->field($model, 'description')->textarea(['rows' => 4, 'placeholder' =>
            'Comments'])->label("Comments");
        ?>
    </div>

    <div class="form-group">
        <?= Html::submitButton('Save data element', ['class' => 'btn btn-primary btn-sm']) ?>
    </div>
</div>
<?php ActiveForm::end(); ?>
