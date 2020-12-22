<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model common\models\Role */
/* @var $allocModel common\models\RightAllocation */

$this->title = 'Update ' . $model->role;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->role, 'url' => ['view', 'id' => $model->id]];

?>
<div class="card card-success card-outline">
    <div class="card-body">
        <?=
        $this->render('_form', [
            'model' => $model
        ])
        ?>

    </div>
</div>
