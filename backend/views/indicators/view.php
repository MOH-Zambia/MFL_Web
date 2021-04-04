<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\Indicators */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Indicators', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p class="float-left">
            <?php
            if (User::userIsAllowedTo('Manage indicators')) {
                echo Html::a(
                        '<span class="fas fa-edit"></span>', ['update', 'id' => $model->id], [
                    'title' => 'Update rule',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'data-pjax' => '0',
                    'style' => "padding:5px;",
                    'class' => 'bt btn-lg'
                        ]
                );
            }
            if (User::userIsAllowedTo('Remove indicators')) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo Html::a(
                        '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                    'title' => 'Remove indicator',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'data' => [
                        'confirm' => 'Are you sure you want to indicator: ' . $model->name . '?<br>'
                        . 'Indicator will only be removed if its not being used by the system!',
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
                    ['/indicators/download', 'id' => $model->id], [
                'title' => 'Download indicator',
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
                [
                    'attribute' => 'indicator_group_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return !empty($model->indicator_group_id) ? backend\models\IndicatorGroup::findOne($model->indicator_group_id)->name : "";
                    }
                ],
                'uid',
                'name',
                'short_name',
                'code',
                'definition',
                'numerator_description',
                'numerator_formula',
                'denominator_description',
                'denominator_formula',
                'indicator_type',
                'annualized',
                'level',
                'favorite',
                [
                    'attribute' => 'use_and_context',
                    'label' => "Use and Context",
                ],
                'frequency',
                //'nids_versions',
                [
                    'label' => 'last updated',
                    'value' => function($model) {
                        return date('Y-m-d h:i:s', $model->updated_at);
                    }
                ],
            ],
        ])
        ?>

    </div>
</div>
