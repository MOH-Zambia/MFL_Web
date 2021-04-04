<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLFacility */

$this->title = 'Add Facility';
$this->params['breadcrumbs'][] = ['label' => 'Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline">
    <div class="card-body">
        <div class="col-lg-12">
            <h4>Instructions</h4>
            <ol>
                <li>Fields marked with <span style="color: red;">*</span> are required</li>
                <li>You will be able to add other details such as services,operation etc hours on the view page.</li>
            </ol>
        </div>
        <?=
        $this->render('_form', [
            'model' => $model,
        ])
        ?>

    </div>
</div>
