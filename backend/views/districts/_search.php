<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\DistrictsSearch */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="districts-search">

    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <?= $form->field($model, 'id') ?>

    <?= $form->field($model, 'name') ?>

    <?= $form->field($model, 'population') ?>

    <?= $form->field($model, 'pop_density') ?>

    <?= $form->field($model, 'area_sq_km') ?>

    <?php // echo $form->field($model, 'geom') ?>

    <?php // echo $form->field($model, 'district_type_id') ?>

    <?php // echo $form->field($model, 'province_id') ?>

    <div class="form-group">
        <?= Html::submitButton('Search', ['class' => 'btn btn-primary']) ?>
        <?= Html::resetButton('Reset', ['class' => 'btn btn-outline-secondary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
