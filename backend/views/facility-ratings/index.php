<?php

use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\ActionColumn;
use backend\models\User;
use \kartik\popover\PopoverX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MFLFacilityRatingsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facility Ratings';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <?php // echo $this->render('_search', ['model' => $searchModel]); ?>

        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            //'id',
            [
                //'enableSorting' => false,
                'attribute' => 'facility_id',
                'format' => 'raw',
                'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => \backend\models\MFLFacility::getList(),
                'filterInputOptions' => ['prompt' => 'Filter by facility', 'class' => 'form-control',],
                'value' => function ($model) {
                    return backend\models\MFLFacility::findOne($model->facility_id)->name;
                }
            ],
            [
                'enableSorting' => true,
                'attribute' => 'rate_type_id',
                'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => \backend\models\MFLFacilityRateTypes::getList(),
                'filterInputOptions' => ['prompt' => 'Filter by type', 'class' => 'form-control',],
                'format' => 'raw',
                'value'=>function($model){
                return backend\models\MFLFacilityRateTypes::findOne($model->rate_type_id)->name;
                }
            ],
            [
                //'enableSorting' => false,
                'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => [
                    'Very Poor' => 'Very Poor',
                    'Poor' => 'Poor',
                    'Average' => 'Average',
                    'Good' => 'Good',
                    'Very Good' => 'Very Good',
                ],
                'filterInputOptions' => ['prompt' => 'Filter by rating', 'class' => 'form-control',],
                'attribute' => 'rating',
                'format' => 'raw',
            ],
            [
                //'enableSorting' => false,
                'attribute' => 'email',
                'filter' => false,
                'format' => 'raw',
            ],
            [
                //'enableSorting' => false,
                'attribute' => 'comment',
                'filter' => false,
                'format' => 'raw',
            ],
            [
                'attribute' => 'date_created',
                'filter' => false,
                'value' => function($model) {
                    return date('d-M-Y', $model->date_created);
                }
            ],
            ['class' => ActionColumn::className(),
                'options' => ['style' => 'width:130px;'],
                'template' => '{delete}',
                'buttons' => [
                    'delete' => function ($url, $model) {
                        if (User::userIsAllowedTo('Remove facility ratings')) {
                            return Html::a(
                                            '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                                        'title' => 'Remove rating',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to remove MFL facility rating?<br>'
                                            . 'Rating will only be removed if its not being used by the system!',
                                            'method' => 'post',
                                        ],
                                        'style' => "padding:5px;",
                                        'class' => 'bt btn-lg'
                                            ]
                            );
                        }
                    },
                ]
            ],
        ];
        ?>

        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'export' => [
                'showConfirmAlert' => false,
                'target' => GridView::TARGET_BLANK,
                'filename' => 'ratings' . date("YmdHis")
            ],
            //'bordered' => true,
            //'striped' => true,
            'toggleDataContainer' => ['class' => 'btn-group mr-2'],
            'condensed' => true,
            'responsive' => true,
            'hover' => true,
            'columns' => $gridColumns,
            'panel' => [
                'type' => 'default',
            //'heading' => 'Products'
            ]
        ]);
        ?>
    </div>
</div>
