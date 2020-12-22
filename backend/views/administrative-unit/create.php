<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLAdministrativeunit */

$this->title = 'Create Mfl Administrativeunit';
$this->params['breadcrumbs'][] = ['label' => 'Mfl Administrativeunits', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="mfladministrativeunit-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
