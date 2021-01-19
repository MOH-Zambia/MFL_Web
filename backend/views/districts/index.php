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

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DistrictsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Districts';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p>
            <?php
            if (User::userIsAllowedTo('Manage districts')) {
                // echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addNewModal\').modal(); 
                // return false;"><i class="fa fa-plus"></i> Add District</button>';
                echo Html::a('<i class="fa fa-plus"></i> Add District', ['create'], ['class' => 'btn btn-sm btn-primary']);
                echo '<hr class="dotted short">';
            }
            ?>
        </p>
        <?php
        $gridColumns = [
            ['class' => 'yii\grid\SerialColumn'],
            // 'id',
            [
                'class' => EditableColumn::className(),
                'attribute' => 'province_id',
                //'readonly' => false,
                'refreshGrid' => true,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => \backend\models\Provinces::getProvinceList(),
                'filterInputOptions' => ['prompt' => 'Filter by Province', 'class' => 'form-control', 'id' => null],
                'editableOptions' => [
                    'asPopover' => true,
                    'type' => 'primary',
                    'size' => PopoverX::SIZE_MEDIUM,
                    'options' => ['data' => \backend\models\Provinces::getProvinceList(),],
                    'inputType' => Editable::INPUT_SELECT2,
                ],
                'value' => function ($model) {
                    $name = backend\models\Provinces::findOne($model->province_id)->name;
                    return $name;
                },
            ],
            [
                'class' => EditableColumn::className(),
                'attribute' => 'district_type_id',
                //'readonly' => false,
                'refreshGrid' => true,
                'filterType' => GridView::FILTER_SELECT2,
                'filterWidgetOptions' => [
                    'pluginOptions' => ['allowClear' => true],
                ],
                'filter' => \backend\models\DistrictType::getList(),
                'filterInputOptions' => ['prompt' => 'Filter by Type', 'class' => 'form-control', 'id' => null],
                'editableOptions' => [
                    'asPopover' => true,
                    'type' => 'primary',
                    'size' => PopoverX::SIZE_MEDIUM,
                    'options' => ['data' => \backend\models\DistrictType::getList(),],
                    'inputType' => Editable::INPUT_SELECT2,
                ],
                'value' => function ($model) {
                    $name = backend\models\DistrictType::findOne($model->district_type_id)->name;
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
                'filter' => \backend\models\Districts::getNames(),
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
            [
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
                                    'title' => 'View province',
                                    'data-toggle' => 'tooltip',
                                    'data-placement' => 'top',
                                    'data-pjax' => '0',
                                    'style' => "padding:5px;",
                                    'class' => 'bt btn-lg'
                                        ]
                        );
                    },
                    'update' => function ($url, $model) {
                        if (User::userIsAllowedTo('Manage districts')) {
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
                        if (User::userIsAllowedTo('Remove districts')) {
                            return Html::a(
                                            '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                                        'title' => 'Remove province',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to remove ' . $model->name . ' District?<br>'
                                            . 'District will only be removed if its not being used by the system!',
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
                        'filename' => 'districts_export' . date("YmdHis")
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
            echo "<p class='text-sm'>There are currently no districts in the system</p>";
        }
        ?>


    </div>
</div>
<div class="modal fade card-primary card-outline" id="addNewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new District</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $form = ActiveForm::begin([
                                    'action' => 'create',
                                ])
                        ?>
                        <?=
                                $form->field($model, 'province_id')
                                ->dropDownList(
                                        \backend\models\Provinces::getProvinceList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Select a province', 'required' => true]
                        );
                        ?>
                        <?=
                                $form->field($model, 'district_type_id')
                                ->dropDownList(
                                        \backend\models\DistrictType::getList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Select district type', 'required' => true]
                        );
                        ?>
                        <?=
                        $form->field($model, 'name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                            'Name of district', 'required' => true,])
                        ?>
                        <?=
                        $form->field($model, 'population')->widget(NumberControl::classname(), [
                            'displayOptions' => [
                                'placeholder' => 'Enter population in the district'
                            ],
                            'maskedInputOptions' => [
                                'suffix' => ' ',
                                'allowMinus' => false
                            ],
                        ]);
                        ?>
                        <?=
                        $form->field($model, 'pop_density')->widget(NumberControl::classname(), [
                            'displayOptions' => [
                                'placeholder' => 'Enter population density for the district'
                            ],
                            'maskedInputOptions' => [
                                'suffix' => ' ',
                                'allowMinus' => false
                            ],
                        ]);
                        ?>
                        <?=
                        $form->field($model, 'area_sq_km')->widget(NumberControl::classname(), [
                            'displayOptions' => [
                                'placeholder' => 'Enter size of district'
                            ],
                            'maskedInputOptions' => [
                                'suffix' => ' Sq Km',
                                'allowMinus' => false
                            ],
                        ]);
                        ?>
                        <?=
                        $form->field($model, 'geom', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                            'Enter district geometry coordinates', 'required' => true,])
                        ?>
                    </div>
                    <div class="col-lg-4">
                        <h4>Instructions</h4>
                        <ol>
                            <li>Fields marked with <span style="color: red;">*</span> are required</li>
                        </ol>
                    </div>
                </div>
            </div>
            <div class="modal-footer justify-content-between">
                <?= Html::submitButton('Save District', ['class' => 'btn btn-primary btn-sm']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>
<?php
$this->registerCss('.popover-x {display:none}');
?>
