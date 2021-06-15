<?php

use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\ActionColumn;
use backend\models\User;
use kartik\export\ExportMenu;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\ValidationRulesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Validation Rules';
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
                            'enableSorting' => true,
                            'attribute' => 'operator',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filter' => \backend\models\ValidationRuleOperator::getList(),
                            'filterInputOptions' => ['prompt' => 'Filter by operator', 'class' => 'form-control',],
                            'format' => 'raw',
                            'value' => function($model) {
                                return !empty($model->operator) ? backend\models\ValidationRuleOperator::findOne($model->operator)->name : "";
                            }
                        ],
                        //'description',
                        [
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'attribute' => 'left_side',
                            'filter' => false
                        ],
                        [
                            'contentOptions' => ['class' => 'text-left', 'style' => 'font-size:13px;font-weight:normal'],
                            'headerOptions' => ['class' => 'text-center', 'style' => 'font-size:14px;font-weight:normal'],
                            'attribute' => 'right_side',
                            'filter' => false
                        ],
                        //'type',
                        //'created_at',
                        //'updated_at',
                        //'created_by',
                        //'updated_by',
                        ['class' => ActionColumn::className(),
                            'options' => ['style' => 'width:130px;'],
                            'template' => '{view}{update}{delete}',
                            'buttons' => [
                                'view' => function ($url, $model) {
                                    return Html::a(
                                                    '<span class="fa fa-eye"></span>', ['view', 'id' => $model->id], [
                                                'title' => 'View rule',
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
                        // 'id',
                        [
                            'attribute' => 'uid',
                            'filter' => false,
                        ],
                        [
                            'attribute' => 'name',
                            'filter' => false,
                        ],
                        [
                            'enableSorting' => true,
                            'attribute' => 'operator',
                            'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                            'filterWidgetOptions' => [
                                'pluginOptions' => ['allowClear' => true],
                            ],
                            'filter' => \backend\models\ValidationRuleOperator::getList(),
                            'filterInputOptions' => ['prompt' => 'Filter by operator', 'class' => 'form-control',],
                            'format' => 'raw',
                            'value' => function($model) {
                                return !empty($model->operator) ? backend\models\ValidationRuleOperator::findOne($model->operator)->name : "";
                            }
                        ],
                        'description',
                        'left_side',
                        'right_side',
                        'type',
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
                                    // ExportMenu::FORMAT_CSV => false,
                                    ],
                                    'pjaxContainerId' => 'kv-pjax-container',
                                    'exportContainer' => [
                                        'class' => 'btn-group mr-2'
                                    ],
                                    'dropdownOptions' => [
                                        'label' => 'Export to Excel',
                                        'class' => 'btn btn-outline-secondary',
                                        'itemsBefore' => [
                                            '<div class="dropdown-header">Export All Data</div>',
                                        ],
                                    ],
                                    'filename' => 'validation_rules_export' . date("YmdHis")
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
