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
<div class="card card-primary card-outline">
    <div class="card-body">

        <p>
            <?php
            if (User::userIsAllowedTo('Manage nids validation rules')) {
                // echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addNewModal\').modal(); 
                //   return false;"><i class="fa fa-plus"></i> Add Province</button>';
                echo Html::a('<i class="fa fa-plus"></i> Add Validation rule', ['create'], ['class' => 'btn btn-sm btn-primary']);
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
                'enableSorting' => true,
                'attribute' => 'operator',
                'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                'contentOptions'=>['style' => 'width:70px;','width'=>"70px"],
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
            ['attribute' => 'left_side',
                'filter' => false
            ],
            ['attribute' => 'right_side',
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
                    'update' => function ($url, $model) {
                        if (User::userIsAllowedTo('Manage nids validation rules')) {
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
                        if (User::userIsAllowedTo('Remove nids validation rules')) {
                            return Html::a(
                                            '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                                        'title' => 'Remove rule',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to remove validation rule ' . $model->name . '?<br>'
                                            . 'Validation rule will only be removed if its not being used by the system!',
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
