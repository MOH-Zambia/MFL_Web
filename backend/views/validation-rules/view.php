<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\ValidationRules */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Validation rules', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p class="float-left">
            <?php
            if (User::userIsAllowedTo('Manage nids validation rules')) {
                echo Html::a(
                        '<span class="fas fa-edit"></span>', ['update', 'id' => $model->id],
                        [
                            'title' => 'Update rule',
                            'data-toggle' => 'tooltip',
                            'data-placement' => 'top',
                            'data-pjax' => '0',
                            'style' => "padding:5px;",
                            'class' => 'bt btn-lg'
                        ]
                );
            }
            if (User::userIsAllowedTo('Remove nids validation rules')) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo Html::a(
                        '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                    'title' => 'Remove rule',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'data' => [
                        'confirm' => 'Are you sure you want to validation rule ' . $model->name . '?<br>'
                        . 'Validation rule will only be removed if its not being used by the system!',
                        'method' => 'post',
                    ],
                    'style' => "padding:5px;",
                    'class' => 'bt btn-lg'
                        ]
                );
            }
            //This is a hack, just to use pjax for the delete confirm button
            $query = User::find()->where(['id' => '-2']);
            $dataProvider = new \yii\data\ActiveDataProvider([
                'query' => $query,
            ]);
            GridView::widget([
                'dataProvider' => $dataProvider,
            ]);
            ?>
        </p>
        <p class="float-right">
            <?php
            echo Html::a(
                    'Download: <i class="fas fa-file-pdf fa-2x"></i>',
                    ['/validation-rules/download','id' => $model->id], [
                'title' => 'Download rule',
                'target' => '_blank',
                'data-toggle' => 'tooltip',
                'data-placement' => 'top',
                'data-pjax' => '0',
                'style' => "padding:5px;",
                    ]
            );
            ?>
        </p>
        <?=
        DetailView::widget([
            'model' => $model,
            'attributes' => [
                // 'id',
                'uid',
                'name',
                [
                    'attribute' => 'operator',
                    'value' => function($model) {
                        return !empty($model->operator) ? backend\models\ValidationRuleOperator::findOne($model->operator)->name : "";
                    }
                ],
                'description',
                'left_side',
                'right_side',
                'type',
                [
                    'label' => 'last updated',
                    'value' => function($model) {
                        return date('Y-m-d', $model->updated_at);
                    }
                ],
            ],
        ])
        ?>

    </div>
</div>
