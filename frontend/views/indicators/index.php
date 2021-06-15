<?php

use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\ActionColumn;
use backend\models\User;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\IndicatorsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Indicators';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row"  style="margin-right:-50px;margin-left:-50px;">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-body">


                    <?php
                    $gridColumns = [
                        // ['class' => 'yii\grid\SerialColumn'],
                        // 'id',
                        [
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'attribute' => 'uid',
                            'filter' => false,
                        ],
                        [
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'attribute' => 'name',
                            'filter' => false,
                        ],
                        [
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'attribute' => 'short_name',
                            'filter' => false,
                        ],
                        [
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'attribute' => 'code',
                            'filter' => false,
                        ],
                        [
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'enableSorting' => true,
                            'attribute' => 'indicator_group_id',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            //'contentOptions' => ['style' => 'width:70px;', 'width' => "70px"],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filter' => \backend\models\IndicatorGroup::getList(),
                            'filterInputOptions' => ['prompt' => 'Filter by group', 'class' => 'form-control',],
                            'format' => 'raw',
                            'value' => function($model) {
                                return !empty($model->indicator_group_id) ? backend\models\IndicatorGroup::findOne($model->indicator_group_id)->name : "";
                            }
                        ],
                        ['class' => ActionColumn::className(),
                            'options' => ['style' => 'width:40px;'],
                            'template' => '{view}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a(
                                                    '<span class="fa fa-eye"></span>', ['view', 'id' => $model->id], [
                                                'title' => 'View',
                                                'data-toggle' => 'tooltip',
                                                'data-placement' => 'top',
                                                'data-pjax' => '0',
                                                'style' => "padding:5px;",
                                                'class' => 'bt btn-lg'
                                                    ]
                                    );
                                },
                            ]
                        ],
                    ];
                    $gridColumns2 = [
                        ['class' => 'yii\grid\SerialColumn'],
                        'id',
                        'uid',
                        'name',
                        'short_name',
                        'code',
                        [
                            'attribute' => 'indicator_group_id',
                            'format' => 'raw',
                            'value' => function($model) {
                                return !empty($model->indicator_group_id) ? backend\models\IndicatorGroup::findOne($model->indicator_group_id)->name : "";
                            }
                        ],
                        'definition',
                        'numerator_description',
                        'numerator_formula',
                        'denominator_description',
                        'denominator_formula',
                        'indicator_type',
                        'annualized',
                        'use_and_context',
                        'frequency',
                        'level',
                        'favorite',
                            //'nids_versions',
                            //'created_at',
                            //'updated_at',
                            //'created_by',
                            //'updated_by',
                    ];


                    $fullExportMenu = "";
                    if (!empty($dataProvider) && $dataProvider->getCount() > 0) {
                        $fullExportMenu = ExportMenu::widget([
                                    'dataProvider' => $dataProvider,
                                    'columns' => $gridColumns2,
                                    'columnSelectorOptions' => [
                                        'label' => 'Cols...',
                                    ],
                                    'batchSize' => 200,
                                    // 'hiddenColumns' => [0, 9],
                                    //'disabledColumns' => [1, 2],
                                    //'target' => ExportMenu::TARGET_BLANK,
                                    'exportConfig' => [
                                        ExportMenu::FORMAT_TEXT => false,
                                        ExportMenu::FORMAT_HTML => false,
                                        ExportMenu::FORMAT_EXCEL => false,
                                        ExportMenu::FORMAT_PDF => false,
                                    // ExportMenu::FORMAT_CSV => true,
                                    ],
                                    'pjaxContainerId' => 'kv-pjax-container',
                                    'exportContainer' => [
                                        'class' => 'btn-group mr-2'
                                    ],
                                    'dropdownOptions' => [
                                        'label' => 'Export to Excel',
                                        'class' => 'btn btn-outline-secondary',
                                        'itemsBefore' => [
                                            '<div class="dropdown-header">Export all indicators</div>',
                                        ],
                                    ],
                                    'filename' => 'indicators_export' . date("YmdHis")
                        ]);
                    }
                    echo GridView::widget([
                        'dataProvider' => $dataProvider,
                        'filterModel' => $searchModel,
                        'columns' => $gridColumns,
                        'condensed' => true,
                        'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                        'panel' => [
                            'type' => GridView::TYPE_DEFAULT,
                        ],
                        // set a label for default menu
                        'export' => false,
                        'exportContainer' => [
                            'class' => 'btn-group mr-2'
                        ],
                        // your toolbar can include the additional full export menu
                        'toolbar' => [
                            '{export}',
                            $fullExportMenu,
                        ]
                    ]);
                    ?>
                </div>
            </div>
        </div>
    </div>
</div>
