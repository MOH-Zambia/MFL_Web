<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLAdministrativeunit */

$this->title = 'Update Mfl Administrativeunit: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Mfl Administrativeunits', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="mfladministrativeunit-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
