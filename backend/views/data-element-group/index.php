<?php


use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use yii\grid\ActionColumn;
use backend\models\User;
use kartik\editable\Editable;
use \kartik\popover\PopoverX;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\DataElementGroupSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Data element groups';
$this->params['breadcrumbs'][] = $this->title;
$readonly=true;
?>
<div class="card card-primary card-outline">
    <div class="card-body">
        <p>
            <?php
            if (User::userIsAllowedTo('Manage data element groups')) {
                $readonly=false;
                echo '<button class="btn btn-primary btn-xs" href="#" onclick="$(\'#addNewModal\').modal(); 
                   return false;"><i class="fa fa-plus"></i> Add data element group</button>';
            }
            ?>
        </p>
        <?=
        GridView::widget([
            'dataProvider' => $dataProvider,
            'filterModel' => $searchModel,
            'condensed' => true,
            'hover' => true,
            'columns' => [
                // ['class' => 'yii\grid\SerialColumn'],
                //'id',
                [
                    'class' => EditableColumn::className(),
                    'enableSorting' => true,
                    'readonly'=>$readonly,
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
                    'filter' => \backend\models\DataElementGroup::getList(),
                    'filterInputOptions' => ['prompt' => 'Filter by name', 'class' => 'form-control',],
                    'format' => 'raw',
                    'refreshGrid' => true,
                ],
                [
                    'class' => EditableColumn::className(),
                    'enableSorting' => true,
                    'readonly'=>$readonly,
                    'editableOptions' => [
                        'asPopover' => true,
                        'type' => 'success',
                        'inputType' => kartik\editable\Editable::INPUT_TEXTAREA,
                        'submitOnEnter' => false,
                        'placement' => \kartik\popover\PopoverX::ALIGN_TOP,
                        'size' => PopoverX::SIZE_LARGE,
                        'options' => [
                            'class' => 'form-control',
                            'rows' => 6,
                            'placeholder' => 'Enter description...',
                            'style' => 'width:460px;',
                        ]
                    ],
                    'refreshGrid' => true,
                    'attribute' => 'description',
                    'filter' => false,
                ],
                ['class' => ActionColumn::className(),
                    'options' => ['style' => 'width:20px;'],
                    'template' => '{delete}',
                    'buttons' => [
                        'delete' => function ($url, $model) {
                            if (User::userIsAllowedTo('Remove data element groups')) {
                                return Html::a(
                                                '<span class="fa fa-trash"></span>', ['delete', 'id' => $model->id], [
                                            'title' => 'Remove indicator group',
                                            'data-toggle' => 'tooltip',
                                            'data-placement' => 'top',
                                            'data' => [
                                                'confirm' => 'Are you sure you want to remove data element group:' . $model->name . '?<br>'
                                                . 'Group will only be removed if its not being used by the system!',
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
            ],
        ]);
        ?>


    </div>
</div>

<div class="modal fade card-primary card-outline" id="addNewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add new data element group</h5>
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
                        $form->field($model, 'name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                            'Name of data element group', 'required' => true,])
                        ?>
                        <?=
                        $form->field($model, 'description')->textarea(['rows' => 4, 'placeholder' =>
                            'Data element group description'])->label("Description ");
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
                <?= Html::submitButton('Save group', ['class' => 'btn btn-primary btn-sm']) ?>
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
