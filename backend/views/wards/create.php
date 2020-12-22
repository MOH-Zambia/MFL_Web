<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Wards */

$this->title = 'Create Wards';
$this->params['breadcrumbs'][] = ['label' => 'Wards', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="wards-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
