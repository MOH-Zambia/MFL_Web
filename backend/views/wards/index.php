<?php

use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\ActionColumn;
use backend\models\User;
use kartik\number\NumberControl;
use kartik\popover\PopoverX;
use kartik\export\ExportMenu;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\WardsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Wards';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p>
            <?php
            if (User::userIsAllowedTo('Manage wards')) {
                /* echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addNewModal\').modal(); 
                  return false;"><i class="fa fa-plus"></i> Add Wards</button>'; */
                echo Html::a('<i class="fa fa-plus"></i> Add Ward', ['create'], ['class' => 'btn btn-sm btn-primary']);
                echo '<hr class="dotted short">';
            }
            ?>
        </p>

        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            [
                'attribute' => 'province_id',
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => true,
                'filter' => \backend\models\Provinces::getProvinceList(),
                'filterInputOptions' => ['prompt' => 'Filter by Province', 'class' => 'form-control', 'id' => null],
                'value' => function ($model) {
                    //$district_id = !empty($model->constituency_id) ? backend\models\Constituency::findOne($model->constituency_id)->district_id : "";
                    $province_id = !empty($model->district_id) ? backend\models\Districts::findOne($model->district_id)->province_id : "";
                    $name = !empty($province_id) ? backend\models\Provinces::findOne($province_id)->name : "";
                    return $name;
                },
            ],
            [
                'class' => EditableColumn::className(),
                'attribute' => 'district_id',
                //'readonly' => false,
                'refreshGrid' => true,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => \backend\models\Districts::getList(),
                'filterInputOptions' => ['prompt' => 'Filter by District', 'class' => 'form-control', 'id' => null],
                'editableOptions' => [
                    'asPopover' => true,
                    'type' => 'primary',
                    'size' => PopoverX::SIZE_MEDIUM,
                    'options' => ['data' => \backend\models\Districts::getList()],
                    'inputType' => Editable::INPUT_SELECT2,
                ],
                'value' => function ($model) {
                    $name = !empty($model->district_id) ? backend\models\Districts::findOne($model->district_id)->name : "";
                    return $name;
                },
            ],
            [
                'class' => EditableColumn::className(),
                'attribute' => 'constituency_id',
                //'readonly' => false,
                'refreshGrid' => true,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => \backend\models\Constituency::getList(),
                'filterInputOptions' => ['prompt' => 'Filter by Constituency', 'class' => 'form-control', 'id' => null],
                'editableOptions' => [
                    'asPopover' => true,
                    'type' => 'primary',
                    'size' => PopoverX::SIZE_MEDIUM,
                    'options' => ['data' => \backend\models\Constituency::getList(),],
                    'inputType' => Editable::INPUT_SELECT2,
                ],
                'value' => function ($model) {
                    $name = !empty($model->constituency_id) ? backend\models\Constituency::findOne($model->constituency_id)->name : "";
                    return $name;
                },
            ],
            [
                'class' => EditableColumn::className(),
                'enableSorting' => true,
                'attribute' => 'name',
                'editableOptions' => [
                    'asPopover' => true,
                    'type' => 'primary',
                    'size' => kartik\popover\PopoverX::SIZE_MEDIUM,
                ],
                'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => \backend\models\Wards::getNames(),
                'filterInputOptions' => ['prompt' => 'Filter by name', 'class' => 'form-control',],
                'format' => 'raw',
                'refreshGrid' => true,
            ],
            [
                'class' => EditableColumn::className(),
                'enableSorting' => true,
                'editableOptions' => [
                    'asPopover' => true,
                    'type' => 'primary',
                    'size' => kartik\popover\PopoverX::SIZE_MEDIUM,
                ],
                'refreshGrid' => true,
                'attribute' => 'population',
                'filter' => false,
            ],
            /* [
              'class' => EditableColumn::className(),
              'enableSorting' => true,
              'editableOptions' => [
              'asPopover' => true,
              'type' => 'primary',
              'size' => kartik\popover\PopoverX::SIZE_MEDIUM,
              ],
              'refreshGrid' => true,
              'attribute' => 'pop_density',
              'filter' => false,
              ], */
            [
                'class' => EditableColumn::className(),
                'enableSorting' => true,
                'editableOptions' => [
                    'asPopover' => true,
                    'type' => 'primary',
                    'size' => kartik\popover\PopoverX::SIZE_MEDIUM,
                ],
                'refreshGrid' => true,
                'attribute' => 'area_sq_km',
                'filter' => false,
            ],
            // 'geom',
            ['class' => ActionColumn::className(),
                'options' => ['style' => 'width:130px;'],
                'template' => '{view}{update}{delete}',
                'buttons' => [
                    'view' => function ($url, $model) {
                        return Html::a(
                                        '<span class="fa fa-eye"></span>', ['view', 'id' => $model->id], [
                                    'title' => 'View ward',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                    'data-pjax' => '0',
                                    'style' => "padding:5px;",
                                    'class' => 'bt btn-lg'
                                        ]
                        );
                    },
                    'update' => function ($url, $model) {
                        if (User::userIsAllowedTo('Manage wards')) {
                            return Html::a(
                                            '<span class="fas fa-edit"></span>', ['update', 'id' => $model->id], [
                                        'title' => 'Update all details',
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
                        if (User::userIsAllowedTo('Remove wards')) {
                            return Html::a(
                                            '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                                        'title' => 'Remove ward',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to remove ' . $model->name . ' ward?<br>'
                                            . 'Ward will only be removed if its not being used by the system!',
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
        /* if ($dataProvider->getCount() > 0) {
          echo
          ExportMenu::widget([
          'dataProvider' => $dataProvider,
          'columns' => $gridColumns,
          'fontAwesome' => true,
          'dropdownOptions' => [
          'label' => 'Export All',
          'class' => 'btn btn-default'
          ],
          'filename' => 'districts' . date("YmdHis")
          ]);
          } */
        ?>
        <?php
        if (!empty($dataProvider) && $dataProvider->getCount() > 0) {
            $fullExportMenu = ExportMenu::widget([
                        'dataProvider' => $dataProvider,
                        'columns' => $gridColumns,
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
                        'filename' => 'wards_export' . date("YmdHis")
            ]);
            //  echo "<p class='text-sm'>Found " . $dataProvider->getCount() . " search record(s)</p>";
            echo GridView::widget([
                'dataProvider' => $dataProvider,
                'filterModel' => $searchModel,
                'columns' => $gridColumns,
                'condensed' => true,
                'responsive' => true,
                'hover' => true,
                // 'pjax' => true,
                'pjaxSettings' => ['options' => ['id' => 'kv-pjax-container']],
                'panel' => [
                    'type' => GridView::TYPE_DEFAULT,
                // 'heading' => '<h3 class="panel-title"><i class="fas fa-book"></i> Library</h3>',
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
        } else {
            echo "<p class='text-sm'>There are currently no wards in the system</p>";
        }
        ?>

    </div>
</div>


<?php
$this->registerCss('.popover-x {display:none}');
?>

