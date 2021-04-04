<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLFacilityRatings */

$this->title = 'Update Mfl Facility Ratings: ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => 'Mfl Facility Ratings', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->id, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mflfacility-ratings-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
