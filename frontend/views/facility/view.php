<?php

use yii\widgets\DetailView;
use kartik\grid\GridView;
use dosamigos\google\maps\LatLng;
use dosamigos\google\maps\services\DirectionsWayPoint;
use dosamigos\google\maps\services\TravelMode;
use dosamigos\google\maps\overlays\PolylineOptions;
use dosamigos\google\maps\services\DirectionsRenderer;
use dosamigos\google\maps\services\DirectionsService;
use dosamigos\google\maps\overlays\InfoWindow;
use dosamigos\google\maps\overlays\Marker;
use dosamigos\google\maps\Map;
use dosamigos\google\maps\services\DirectionsRequest;
use dosamigos\google\maps\overlays\Polygon;
use dosamigos\google\maps\layers\BicyclingLayer;
use kartik\form\ActiveForm;
use \yii\data\ActiveDataProvider;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLFacility */

$this->title = $model->name;
$this->params['breadcrumbs'][] = $this->title;

$query_service = backend\models\MFLFacilityServices::find()->where(['facility_id' => $model->id])->orderBy(['service_id' => SORT_ASC]);
$facility_services = new ActiveDataProvider([
    'query' => $query_service,
        ]);

$query_equip = backend\models\MFLFacilityEquipment::find()->where(['facility_id' => $model->id]);
$facility_equipment = new ActiveDataProvider([
    'query' => $query_equip,
        ]);

$query_infra = backend\models\MFLFacilityInfrastructure::find()->where(['facility_id' => $model->id]);
$facility_infrastructure = new ActiveDataProvider([
    'query' => $query_infra,
        ]);

$query_lab = backend\models\MFLFacilityLabLevel::find()->where(['facility_id' => $model->id]);
$facility_lablevel = new ActiveDataProvider([
    'query' => $query_lab,
        ]);

$query_foh = backend\models\MFLFacilityOperatingHours::find()->where(['facility_id' => $model->id]);
$facility_operating_hours = new ActiveDataProvider([
    'query' => $query_foh,
        ]);

\yii\web\YiiAsset::register($this);
?>
<div class="container-fluid">
    <div class="row" style="margin-right:-50px;margin-left:-50px;">
        <div class="col-lg-12">
            <div class="card card-primary card-outline">
                <div class="card card-header">
                    Facility name: <?= $model->name ?>
                </div>
                <div class="card-body">
                    <div class="card card-tabs">
                        <div class="card-header p-0 pt-1 border-bottom-0">
                            <ul class="nav nav-tabs" id="custom-tabs-one-tab" role="tablist">
                                <li class="nav-item">
                                    <a class="nav-link active" id="custom-tabs-one-home-tab" data-toggle="pill" href="#custom-tabs-one-home" role="tab" aria-controls="custom-tabs-one-home" aria-selected="true">Details</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="contact-tab" data-toggle="pill" href="#contact" role="tab" aria-controls="contact" aria-selected="false">Contact info</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="location-tab" data-toggle="pill" href="#location" role="tab" aria-controls="location" aria-selected="false">Location</a>
                                </li>

                                <li class="nav-item">
                                    <a class="nav-link" id="operating-hours-tab" data-toggle="pill" href="#operating-hours" role="tab" aria-controls="operating-hours" aria-selected="false">Operating hours</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-profile-tab" data-toggle="pill" href="#custom-tabs-one-profile" role="tab" aria-controls="custom-tabs-one-profile" aria-selected="false">Services</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-messages-tab" data-toggle="pill" href="#custom-tabs-one-messages" role="tab" aria-controls="custom-tabs-one-messages" aria-selected="false">Infrastructure</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" id="custom-tabs-one-settings-tab" data-toggle="pill" href="#custom-tabs-one-settings" role="tab" aria-controls="custom-tabs-one-settings" aria-selected="false">Equipment</a>
                                </li>
                            </ul>
                        </div>
                        <div class="card-body">
                            <div class="tab-content" id="custom-tabs-one-tabContent">
                                <div class="tab-pane fade show active" id="custom-tabs-one-home" role="tabpanel" aria-labelledby="custom-tabs-one-home-tab">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <?=
                                            DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    'DHIS2_UID',
                                                    'HMIS_code',
                                                    'smartcare_GUID',
                                                    'eLMIS_ID',
                                                    'iHRIS_ID',
                                                    'catchment_population_head_count',
                                                    'catchment_population_cso',
                                                    [
                                                        'attribute' => 'administrative_unit_id',
                                                        'value' => function ($model) {
                                                            $name = !empty($model->administrative_unit_id) ? backend\models\MFLAdministrativeunit::findOne($model->administrative_unit_id)->name : "";
                                                            return $name;
                                                        },
                                                    ],
                                                    [
                                                        'format' => "raw",
                                                        'attribute' => 'operation_status_id',
                                                        'value' => function ($model) {
                                                            $name = !empty($model->operation_status_id) ? backend\models\Operationstatus::findOne($model->operation_status_id)->name : "";
                                                            return "<p style='color:green;'> $name </p>";
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'facility_type_id',
                                                        'value' => function ($model) {
                                                            $name = backend\models\Facilitytype::findOne($model->facility_type_id)->name;
                                                            return $name;
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'ownership_id',
                                                        'value' => function ($model) {
                                                            $name = backend\models\FacilityOwnership::findOne($model->ownership_id)->name;
                                                            return $name;
                                                        },
                                                    ],
                                                    // 'name',
                                                    'number_of_beds',
                                                    'number_of_cots',
                                                    'number_of_nurses',
                                                    'number_of_doctors',
                                                ],
                                            ])
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="contact" role="tabpanel" aria-labelledby="contact">
                                    <?=
                                    DetailView::widget([
                                        'model' => $model,
                                        'attributes' => [
                                            'address_line1',
                                            'address_line2',
                                            'postal_address',
                                            'web_address',
                                            'email:email',
                                            'phone',
                                            'mobile',
                                            'fax',
                                        ],
                                    ])
                                    ?>
                                </div>
                                <div class="tab-pane fade" id="location" role="tabpanel" aria-labelledby="location">
                                    <div class="row">
                                        <div class="col-lg-5">
                                            <?=
                                            DetailView::widget([
                                                'model' => $model,
                                                'attributes' => [
                                                    [
                                                        'attribute' => 'province_id',
                                                        'value' => function ($model) {
                                                            $province_id = backend\models\Districts::findOne($model->district_id)->province_id;
                                                            $name = backend\models\Provinces::findOne($province_id)->name;
                                                            return $name;
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'district_id',
                                                        'value' => function ($model) {
                                                            $name = backend\models\Districts::findOne($model->district_id)->name;
                                                            return $name;
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'constituency_id',
                                                        'value' => function ($model) {
                                                            $name = !empty($model->constituency_id) ? backend\models\Constituency::findOne($model->constituency_id)->name : "";
                                                            return $name;
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'ward_id',
                                                        'value' => function ($model) {
                                                            $name = !empty($model->ward_id) ? backend\models\Wards::findOne($model->ward_id)->name : "";
                                                            return $name;
                                                        },
                                                    ],
                                                    [
                                                        'attribute' => 'location_type_id',
                                                        'value' => function ($model) {
                                                            $name = backend\models\LocationType::findOne($model->location_type_id)->name;
                                                            return $name;
                                                        },
                                                    ],
                                                    [
                                                        'label' => 'Latitude/Longitude',
                                                        'value' => function ($model) {
                                                            $name = backend\models\LocationType::findOne($model->location_type_id)->name;
                                                            return $model->longitude . "/" . $model->latitude;
                                                        },
                                                    ],
                                                ],
                                            ])
                                            ?>

                                        </div>
                                        <div class="col-lg-7">
                                            <?php
                                            $coords = [];
                                            $center_coords = [];
                                            if (empty($model->geom)) {
                                                echo "<div class='alert alert-warning'>There are no location coordinates for facility:" . $model->name . "</div>";
                                            } else {
                                                $coordinate = json_decode($model->geom, true)['coordinates'];
                                                $coord = new LatLng(['lat' => $coordinate[1], 'lng' => $coordinate[0]]);
                                                //$center = round(count($coord) / 2);
                                                $center_coords = $coord;
                                            }
                                            if (empty($coord)) {
                                                $coord = new LatLng([
                                                    'lat' => Yii::$app->params['center_lat'],
                                                    'lng' => Yii::$app->params['center_lng']
                                                ]);
                                            }
                                            $map = new Map([
                                                'center' => $coord,
                                                'streetViewControl' => false,
                                                'mapTypeControl' => true,
                                                'zoom' => 10,
                                                'width' => '100%',
                                                'height' => 500,
                                            ]);
                                            if (!empty($model->geom)) {
                                                $marker = new Marker([
                                                    'position' => $coord,
                                                    'title' => $model->name,
                                                    'icon' => \yii\helpers\Url::to('@web/img/map_icon.png')
                                                ]);

                                                $marker->attachInfoWindow(
                                                        new InfoWindow([
                                                            'content' => '<p>' . $model->name . '</p>'
                                                                ])
                                                );

                                                $map->addOverlay($marker);
                                            }
                                            echo $map->display();
                                            ?>

                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="operating-hours" role="tabpanel" aria-labelledby="operating-hours">
                                    <div class="row"> 
                                        <div class="col-md-10"> 
                                            <!-- /.card-header -->
                                            <div class="card-body p-0">

                                                <?php
                                                if ($facility_operating_hours->getCount() > 0) {
                                                    echo GridView::widget([
                                                        'dataProvider' => $facility_operating_hours,
                                                        //  'filterModel' => $searchModel,
                                                        'condensed' => true,
                                                        'responsive' => true,
                                                        'hover' => true,
                                                        'columns' => [
                                                            ['class' => 'yii\grid\SerialColumn'],
                                                            //'id',
                                                            [
                                                                'attribute' => 'operatinghours_id',
                                                                'filter' => false,
                                                                'value' => function ($facility_operating_hours) {
                                                                    $name = !empty($facility_operating_hours->operatinghours_id) ? \backend\models\Operatinghours::findOne($facility_operating_hours->operatinghours_id)->name : "";
                                                                    return $name;
                                                                },
                                                            ],
                                                        ],
                                                    ]);
                                                } else {
                                                    echo "No operating hours have been set for this facility!";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-profile" role="tabpanel" aria-labelledby="custom-tabs-one-profile-tab">
                                    <div class="row"> 
                                        <div class="col-md-10"> 
                                            <!-- /.card-header -->
                                            <div class="card-body p-0">

                                                </p>
                                                <?php
                                                if ($facility_services->getCount() > 0) {
                                                    echo GridView::widget([
                                                        'dataProvider' => $facility_services,
                                                        //  'filterModel' => $searchModel,
                                                        'condensed' => true,
                                                        'responsive' => true,
                                                        'hover' => true,
                                                        'columns' => [
                                                            ['class' => 'yii\grid\SerialColumn'],
                                                            //'id',
                                                              [
                                                                'label' => 'Service Type',
                                                                'filter' => false,
                                                                'value' => function ($facility_services) {
                                                                    $type_id = \backend\models\FacilityService::findOne($facility_services->service_id)->category_id;
                                                                    $type = !empty($type_id) ? \backend\models\FacilityServicecategory::findOne($type_id)->name : "";
                                                                    return $type;
                                                                },
                                                            ],
                                                            [
                                                                'attribute' => 'service_id',
                                                                'filter' => false,
                                                                'value' => function ($facility_services) {
                                                                    return !empty($facility_services->service_id) ? \backend\models\FacilityService::findOne($facility_services->service_id)->name : "";
                                                                    ;
                                                                },
                                                            ],
                                                          
                                                        ],
                                                    ]);
                                                } else {
                                                    echo "No Facility services found!";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-messages" role="tabpanel" aria-labelledby="custom-tabs-one-messages-tab">
                                    <div class="row"> 
                                        <div class="col-md-10"> 
                                            <!-- /.card-header -->
                                            <div class="card-body p-0">
                                                <?php
                                                if ($facility_infrastructure->getCount() > 0) {
                                                    echo GridView::widget([
                                                        'dataProvider' => $facility_infrastructure,
                                                        //  'filterModel' => $searchModel,
                                                        'condensed' => true,
                                                        'responsive' => true,
                                                        'hover' => true,
                                                        'columns' => [
                                                            ['class' => 'yii\grid\SerialColumn'],
                                                            //'id',
                                                            [
                                                                'attribute' => 'infrastructure_id',
                                                                'filter' => false,
                                                                'value' => function ($facility_infrastructure) {
                                                                    return !empty($facility_infrastructure->infrastructure_id) ? \backend\models\MFLInfrastructure::findOne($facility_infrastructure->infrastructure_id)->name : "";
                                                                },
                                                            ],
                                                            [
                                                                'attribute' => 'value',
                                                                'filter' => false,
                                                            ],
                                                        ],
                                                    ]);
                                                } else {
                                                    echo "No facility infrastructure was found for this facility!";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="custom-tabs-one-settings" role="tabpanel" aria-labelledby="custom-tabs-one-settings-tab">
                                    <div class="row"> 
                                        <div class="col-md-10"> 
                                            <!-- /.card-header -->
                                            <div class="card-body p-0">

                                                <?php
                                                if ($facility_equipment->getCount() > 0) {
                                                    echo GridView::widget([
                                                        'dataProvider' => $facility_equipment,
                                                        //  'filterModel' => $searchModel,
                                                        'condensed' => true,
                                                        'responsive' => true,
                                                        'hover' => true,
                                                        'columns' => [
                                                            ['class' => 'yii\grid\SerialColumn'],
                                                            //'id',
                                                            [
                                                                'attribute' => 'equipment_id',
                                                                'filter' => false,
                                                                'value' => function ($facility_equipment) {
                                                                    return !empty($facility_equipment->equipment_id) ? \backend\models\Equipment::findOne($facility_equipment->equipment_id)->name : "";
                                                                },
                                                            ],
                                                            [
                                                                'attribute' => 'value',
                                                                'filter' => false,
                                                            ],
                                                        ],
                                                    ]);
                                                } else {
                                                    echo "No facility equipment was found for this facility!";
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!-- /.card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


