<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLFacility */

$this->title = 'Update Facility: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mfl Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mflfacility-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
