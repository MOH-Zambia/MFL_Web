<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Constituency */

$this->title = 'Create Constituency';
$this->params['breadcrumbs'][] = ['label' => 'Constituencies', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="constituency-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
