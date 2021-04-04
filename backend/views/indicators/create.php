<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\Indicators */

$this->title = 'Add Indicator';
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
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
