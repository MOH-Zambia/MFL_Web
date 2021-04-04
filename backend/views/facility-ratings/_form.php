<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLFacilityRatings */
/* @var $form yii\widgets\ActiveForm */
?>

<div class="mflfacility-ratings-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'id')->textInput() ?>

    <?= $form->field($model, 'rate_type_id')->textInput() ?>

    <?= $form->field($model, 'rating')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'email')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'comment')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'date_created')->textInput() ?>

    <?= $form->field($model, 'facility_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
