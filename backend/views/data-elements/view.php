<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;
use kartik\grid\GridView;

/* @var $this yii\web\View */
/* @var $model backend\models\DataElements */

$this->title = $model->uid;
$this->params['breadcrumbs'][] = ['label' => 'Data elements', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
\yii\web\YiiAsset::register($this);
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p class="float-left">
            <?php
            if (User::userIsAllowedTo('Manage data elements')) {
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
            if (User::userIsAllowedTo('Remove data elements')) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo Html::a(
                        '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                    'title' => 'Remove indicator',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'top',
                    'data' => [
                        'confirm' => 'Are you sure you want to remove data element: ' . $model->name . '?<br>'
                        . 'Data element will only be removed if its not being used by the system!',
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
                    ['/data-elements/download', 'id' => $model->id], [
                'title' => 'Download data element',
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
                [
                    'attribute' => 'uid',
                ],
                [
                    'attribute' => 'name',
                ],
                [
                    'attribute' => 'short_name',
                    'label' => 'ShortName',
                ],
                [
                    'attribute' => 'code',
                ],
                [
                    'label' => 'DataElementGroup',
                    'attribute' => 'indicator_group_id',
                    'format' => 'raw',
                    'value' => function($model) {
                        return !empty($model->element_group_id) ? backend\models\DataElementGroup::findOne($model->element_group_id)->name : "";
                    }
                ],
                'definition',
                [
                    'attribute' => 'aggregation_type',
                    'label' => 'AggregationType',
                ],
                [
                    'attribute' => 'domain_type',
                    'label' => 'DomainType',
                ],
                'description',
                [
                    'attribute' => 'definition_extended',
                    'label' => 'DefinitionType',
                ],
                [
                    'attribute' => 'use_and_context',
                    'label' => 'UseAndContext',
                ],
                'inclusions',
                'exclusions',
                'collected_by',
                [
                    'attribute' => 'collected_by',
                    'label' => 'CollectedBy',
                ],
                [
                    'attribute' => 'collection_point',
                    'label' => 'CollectionPoint',
                ],
                'tools',
                [
                    'attribute' => 'keep_zero_values',
                    'label' => 'KeepZeroValues',
                ],
                [
                    'attribute' => 'zeroissignificant',
                    'label' => 'ZeroIsSignificant',
                ],
                [
                    'attribute' => 'favorite',
                    'label' => 'Favorite',
                ],
                //'nids_versions',
                //'created_at',
                //'updated_at',
                //'created_by',
                //'updated_by',
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
