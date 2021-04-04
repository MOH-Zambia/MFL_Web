<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\IndicatorsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="indicators-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'uid') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'short_name') ?>

    <?= $form->field($model, 'code') ?>

    <?php // echo $form->field($model, 'definition') ?>

    <?php // echo $form->field($model, 'indicator_group_id') ?>

    <?php // echo $form->field($model, 'numerator_description') ?>

    <?php // echo $form->field($model, 'numerator_formula') ?>

    <?php // echo $form->field($model, 'denominator_description') ?>

    <?php // echo $form->field($model, 'denominator_formula') ?>

    <?php // echo $form->field($model, 'indicator_type') ?>

    <?php // echo $form->field($model, 'annualized') ?>

    <?php // echo $form->field($model, 'use_and_context') ?>

    <?php // echo $form->field($model, 'frequency') ?>

    <?php // echo $form->field($model, 'level') ?>

    <?php // echo $form->field($model, 'favorite') ?>

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
