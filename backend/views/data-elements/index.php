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
<div class="card card-primary card-outline">
    <div class="card-body">


        <p>
            <?php
            if (User::userIsAllowedTo('Manage data elements')) {
                // echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addNewModal\').modal(); 
                //   return false;"><i class="fa fa-plus"></i> Add Province</button>';
                echo Html::a('<i class="fa fa-plus"></i> Add data element', ['create'], ['class' => 'btn btn-sm btn-primary']);
                echo '<hr class="dotted short">';
            }
            ?>
        </p>

        <?php
        $gridColumns = [
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
                'attribute' => 'short_name',
                'label' => 'ShortName',
                'filter' => false,
            ],
            [
                'attribute' => 'code',
                'filter' => false,
            ],
            [
                'enableSorting' => true,
                'label' => 'DataElementGroup',
                'attribute' => 'element_group_id',
                'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                'contentOptions' => ['style' => 'width:70px;', 'width' => "70px"],
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
                    'update' => function ($url, $model) {
                        if (User::userIsAllowedTo('Manage data elements')) {
                            return Html::a(
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
                    },
                    'delete' => function ($url, $model) {
                        if (User::userIsAllowedTo('Remove data elements')) {
                            return Html::a(
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
                            ExportMenu::FORMAT_CSV => false,
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
