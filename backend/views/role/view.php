<?php

use yii\helpers\Html;
use kartik\detail\DetailView;
use common\models\RightAllocation;
use backend\models\User;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model common\models\Role */

$this->title = "Role: " . $model->role;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = $model->role;
\yii\web\YiiAsset::register($this);
$rightsArray = RightAllocation::getRights($model->id);
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p>
            <?php
            if (User::userIsAllowedTo('Manage Roles')) {
                echo Html::a('<i class="fas fa-pencil-alt fa-2x"></i>', ['update', 'id' => $model->id], [
                    'title' => 'Update role',
                    'data-placement' => 'top',
                    'data-toggle' => 'tooltip'
                ]);

                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo Html::a('<i class="fas fa-trash fa-2x"></i>', ['delete', 'id' => $model->id], [
                    'title' => 'Remove role',
                    'data-placement' => 'top',
                    'data-toggle' => 'tooltip',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete ' . $model->role . ' role?<br>'
                        . 'Role will only be removed if no user is assigned the role!',
                        'method' => 'post',
                    ],
                ]);
            }
            ?>
        </p>
        <?php
        //This is a hack, just to use pjax for the delete confirm button
        $query = User::find()->where(['id' => '-2']);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        GridView::widget([
            'dataProvider' => $dataProvider,
        ]);
        ?>
        <?php
        $attributes = [
            [
                'columns' => [
                    [
                        'label' => 'Rights',
                        'value' => implode(", ", $rightsArray),
                      //  'valueColOptions' => ['style' => 'width:95%']
                    ],
                ],
            ],
            [
                'columns' => [
                    [
                        'attribute' => 'created_by',
                        'value' => !empty($model->created_by) ? User::findOne(['id' => $model->created_by])->getFullName() : ""
                    ],
                ],
            ],
            [
                'columns' => [
                   [
                    'attribute' => 'created_at',
                    'value' => date('d-M-Y', $model->created_at)
                ],
                ],
            ],
        ];


        echo DetailView::widget([
            'model' => $model,
            'condensed' => true,
            'striped' => true,
            // 'condensed' => $condensed,
            'responsive' => true,
            'hover' => true,
            'hAlign' => DetailView::ALIGN_LEFT,
            'vAlign' => DetailView::ALIGN_MIDDLE,
            'mode' => DetailView::MODE_VIEW,
            'attributes' => $attributes
        ]);
        ?>
    </div>

</div>
