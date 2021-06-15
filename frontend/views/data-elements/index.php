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

$this->title = 'Data elements';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row"  style="margin-right:-50px;margin-left:-50px;">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-body">


                    <?php
                    $gridColumns = [
                        ['class' => 'yii\grid\SerialColumn'],
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
                            'label' => 'ShortName',
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
                            'label' => 'DataElementGroup',
                            'attribute' => 'element_group_id',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filter' => \backend\models\DataElementGroup::getList(),
                            'filterInputOptions' => ['prompt' => 'Filter by element group', 'class' => 'form-control',],
                            'format' => 'raw',
                            'value' => function($model) {
                                return !empty($model->element_group_id) ? backend\models\DataElementGroup::findOne($model->element_group_id)->name : "";
                            }
                        ],
                        ['class' => ActionColumn::className(),
                            'options' => ['style' => 'width:130px;'],
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
                        //'id',
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
                                    //ExportMenu::FORMAT_CSV => false,
                                    ],
                                    'pjaxContainerId' => 'kv-pjax-container',
                                    'exportContainer' => [
                                        'class' => 'btn-group mr-2'
                                    ],
                                    'dropdownOptions' => [
                                        'label' => 'Export to Excel',
                                        'class' => 'btn btn-outline-secondary',
                                        'itemsBefore' => [
                                            '<div class="dropdown-header">Export all elements</div>',
                                        ],
                                    ],
                                    'filename' => 'dataelements_export' . date("YmdHis")
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
