<?php

use kartik\editable\Editable;
use kartik\grid\EditableColumn;
use kartik\grid\GridView;
use yii\helpers\Html;
use kartik\form\ActiveForm;
use backend\models\User;
use common\models\Role;
use \kartik\popover\PopoverX;
use yii\grid\ActionColumn;

/* @var $this yii\web\View */
/* @var $searchModel backend\models\MFLFacilitySearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Facilities';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="container-fluid">
    <div class="row"  style="margin-right:-100px;margin-left:-100px;">
        <div class="col-lg-12 text-sm">
            <div class="card card-primary">
                <div class="card-body">
                    <p>Filter facilities below </p>

                    <?php echo $this->render('_search', ['model' => $searchModel]); ?>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card-body">
                    <p>
                    <hr class="dotted short">
                    </p>

                    <?php
                    echo "<p class='text-sm'>Filter facilities using the form above</p>";
                    if ($dataProvider->getCount() > 0) {
                        echo GridView::widget([
                            'dataProvider' => $dataProvider,
                            'filterModel' => $searchModel,
                            'condensed' => true,
                            'responsive' => true,
                            'hover' => true,
                            'panel' => [
                                'type' => 'default',
                                'heading' => 'Facilities'
                            ],
                            'columns' => [
                                ['class' => 'yii\grid\SerialColumn'],
                                //'id',
                                [
                                    'enableSorting' => true,
                                    'attribute' => 'name',
                                    'filterType' => \kartik\grid\GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filter' => \backend\models\MFLFacility::getNames(),
                                    'filterInputOptions' => ['prompt' => 'Filter by name', 'class' => 'form-control',],
                                    'format' => 'raw',
                                ],
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
                                    'attribute' => 'district_id',
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filter' => \backend\models\Districts::getList(),
                                    'filterInputOptions' => ['prompt' => 'Filter by District', 'class' => 'form-control', 'id' => null],
                                    'value' => function ($model) {
                                        $name = backend\models\Districts::findOne($model->district_id)->name;
                                        return $name;
                                    },
                                ],
                                [
                                    'attribute' => 'facility_type_id',
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filter' => \backend\models\Facilitytype::getList(),
                                    'filterInputOptions' => ['prompt' => 'Filter by facility type', 'class' => 'form-control', 'id' => null],
                                    'value' => function ($model) {
                                        $name = backend\models\Facilitytype::findOne($model->facility_type_id)->name;
                                        return $name;
                                    },
                                ],
                                [
                                    'attribute' => 'ownership_id',
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filter' => \backend\models\FacilityOwnership::getList(),
                                    'filterInputOptions' => ['prompt' => 'Filter by ownership', 'class' => 'form-control', 'id' => null],
                                    'value' => function ($model) {
                                        $name = backend\models\FacilityOwnership::findOne($model->ownership_id)->name;
                                        return $name;
                                    },
                                ],
                                [
                                    'format' => 'raw',
                                    'attribute' => 'operation_status_id',
                                    'filterType' => GridView::FILTER_SELECT2,
                                    'filterWidgetOptions' => [
                                        'pluginOptions' => ['allowClear' => true],
                                    ],
                                    'filter' => \backend\models\Operationstatus::getList(),
                                    'filterInputOptions' => ['prompt' => 'Filter by status', 'class' => 'form-control', 'id' => null],
                                    'value' => function ($model) {
                                        $name = backend\models\Operationstatus::findOne($model->operation_status_id)->name;

                                        return strtoupper($name) === "OPERATIONAL" ? "<p style='Color: green;'>$name</p>" : "<p style='Color: red;'> $name</p>";
                                    },
                                ],
                                // 'DHIS2_UID',
                                //'HMIS_code',
                                // 'smartcare_GUID',
                                // 'eLMIS_ID',
                                // 'iHRIS_ID',
                                //'number_of_beds',
                                //'number_of_cots',
                                //'number_of_nurses',
                                //'number_of_doctors',
                                //'address_line1',
                                //'address_line2',
                                //'postal_address',
                                //'web_address',
                                //'email:email',
                                //'phone',
                                //'mobile',
                                //'fax',
                                //'catchment_population_head_count',
                                //'catchment_population_cso',
                                //'star:ntext',
                                //'rated:ntext',
                                //'rating:ntext',
                                //'longitude',
                                //'latitude',
                                //'comment:ntext',
                                //'geom',
                                //'timestamp',
                                //'updated',
                                //'slug',
                                //'administrative_unit_id',
                                //'constituency_id',
                                //'location_type_id',
                                //'operation_status_id',
                                //'ownership_id',
                                //'ward_id',
                                ['class' => ActionColumn::className(),
                                    //'options' => ['style' => 'width:130px;'],
                                    'template' => '{view}',
                                    'buttons' => [
                                        'view' => function ($url, $model) {
                                            return Html::a(
                                                            '<span class="fa fa-eye"></span>', ['view', 'id' => $model->id], [
                                                        'title' => 'View facility',
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
                            ],
                        ]);
                    }
                    ?>

                </div>
            </div>
        </div>
    </div>
</div>

