<?php

/* @var $this yii\web\View */
/* @var $model common\models\Role */
/* @var $allocModel common\models\RightAllocation */

$this->title = 'Add Role';
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline">
    <div class="card-body">

    <?= $this->render('_form', [
        'model' => $model
    ]) ?>
    </div>
</div>
