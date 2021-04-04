<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\ValidationRules */

$this->title = 'Create validation rule';
$this->params['breadcrumbs'][] = ['label' => 'Validation rules', 'url' => ['index']];
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
