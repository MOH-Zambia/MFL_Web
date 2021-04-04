<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Indicators */

$this->title = 'Update Indicator: ' . $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->uid, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
