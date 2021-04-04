<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DataElementsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="data-elements-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'element_group_id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'short_name') ?>

    <?php // echo $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'definition') ?>

    <?php // echo $form->field($model, 'aggregation_type') ?>

    <?php // echo $form->field($model, 'domain_type') ?>

    <?php // echo $form->field($model, 'description') ?>

    <?php // echo $form->field($model, 'definition_extended') ?>

    <?php // echo $form->field($model, 'use_and_context') ?>

    <?php // echo $form->field($model, 'inclusions') ?>

    <?php // echo $form->field($model, 'exclusions') ?>

    <?php // echo $form->field($model, 'collected_by') ?>

    <?php // echo $form->field($model, 'collection_point') ?>

    <?php // echo $form->field($model, 'tools') ?>

    <?php // echo $form->field($model, 'keep_zero_values') ?>

    <?php // echo $form->field($model, 'zeroissignificant') ?>

    <?php // echo $form->field($model, 'nids_versions') ?>

    <?php // echo $form->field($model, 'created_at') ?>

    <?php // echo $form->field($model, 'updated_at') ?>

    <?php // echo $form->field($model, 'created_by') ?>

    <?php // echo $form->field($model, 'updated_by') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
