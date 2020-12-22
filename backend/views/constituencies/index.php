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
/* @var $searchModel backend\models\ConstituencySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Constituencies';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="card card-primary card-outline">
    <div class="card-body">

        <p>
            <?php
            if (User::userIsAllowedTo('Manage constituencies')) {
                echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addNewModal\').modal(); 
                    return false;"><i class="fa fa-plus"></i> Add Constituency</button>';
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
                    $province_id = backend\models\Districts::findOne($model->district_id)->province_id;
                    $name = backend\models\Provinces::findOne($province_id)->name;
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
                    'options' => ['data' => \backend\models\Districts::getList(),],
                    'inputType' => Editable::INPUT_SELECT2,
                   
                ],
                'value' => function ($model) {
                    $name = backend\models\Districts::findOne($model->district_id)->name;
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
                'filter' => \backend\models\Constituency::getNames(),
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
                'template' => '{view}{delete}',
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
                    'delete' => function ($url, $model) {
                        if (User::userIsAllowedTo('Remove constituencies')) {
                            return Html::a(
                                            '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                                        'title' => 'Remove constituency',
                                        'data-toggle' => 'tooltip',
                                        'data-placement' => 'top',
                                        'data' => [
                                            'confirm' => 'Are you sure you want to remove ' . $model->name . ' constituency?<br>'
                                            . 'Constituency will only be removed if its not being used by the system!',
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
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'export' => [
                'showConfirmAlert' => false,
                'target' => GridView::TARGET_BLANK,
                'filename' => 'constituencies' . date("YmdHis")
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
<div class="modal fade card-primary card-outline" id="addNewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new Constituency</h5>
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
                        <?php
                        echo
                                $form->field($model, 'province_id')
                                ->dropDownList(
                                        \backend\models\Provinces::getProvinceList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Please select a province', 'required' => true]
                        );

                        echo Html::hiddenInput('selected_id', $model->isNewRecord ? '' : $model->district_id, ['id' => 'selected_id']);

                        echo $form->field($model, 'district_id')->widget(DepDrop::classname(), [
                            'options' => ['id' => 'dist_id', 'custom' => true, 'required' => TRUE],
                            'pluginOptions' => [
                                'depends' => ['prov_id'],
                                'initialize' => $model->isNewRecord ? false : true,
                                'placeholder' => 'Please select a district',
                                'url' => Url::to(['/constituencies/district']),
                                'params' => ['selected_id'],
                            ]
                        ]);
                        ?>
                        <?=
                        $form->field($model, 'name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                            'Name of constituency', 'required' => true,])
                        ?>
                        <?=
                        $form->field($model, 'population')->widget(NumberControl::classname(), [
                            'displayOptions' => [
                                'placeholder' => 'Enter population in the constituency'
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
                                'placeholder' => 'Enter population density for the constituency'
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
                                'placeholder' => 'Enter size of constituency'
                            ],
                            'maskedInputOptions' => [
                                'suffix' => ' Sq Km',
                                'allowMinus' => false
                            ],
                        ]);
                        ?>
                        <?=
                        $form->field($model, 'geom', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                            'Enter constituency geometry coordinates', 'required' => true,])
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
                <?= Html::submitButton('Save Constituency', ['class' => 'btn btn-primary btn-sm']) ?>
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
