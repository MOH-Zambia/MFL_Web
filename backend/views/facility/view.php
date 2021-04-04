<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use backend\models\User;
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
use yii\grid\ActionColumn;
use kartik\widgets\StarRating;

/* @var $this yii\web\View */
/* @var $model backend\models\MFLFacility */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Facilities', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

$query_service = backend\models\MFLFacilityServices::find()->where(['facility_id' => $model->id]);
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


$facility_rate_count = \backend\models\MFLFacilityRatings::find()
                ->cache(Yii::$app->params['cache_duration'])
                ->where(['facility_id' => $model->id])->count();
$facility_rates_sum = \backend\models\MFLFacilityRatings::find()
        ->cache(Yii::$app->params['cache_duration'])
        ->where(['facility_id' => $model->id])
        ->sum('rate_value');
$rating = !empty($facility_rate_count) && !empty($facility_rates_sum) ? $facility_rates_sum / $facility_rate_count : 0;
$rating_model = new \backend\models\MFLFacilityRatings();
$rate_type_model = \backend\models\MFLFacilityRateTypes::find()
        ->cache(Yii::$app->params['cache_duration'])
        ->all();
?>
<div class="card card-primary card-outline">
    <div class="card-header border-transparent">
        <h3 class="card-title">
            <?php
            if (User::userIsAllowedTo('Manage facilities')) {
                echo Html::a('<i class="fas fa-pencil-alt fa-2x"></i>', ['update', 'id' => $model->id], [
                    'title' => 'Update facility',
                    'data-placement' => 'top',
                    'data-toggle' => 'tooltip'
                ]);
            }
            if (User::userIsAllowedTo('Manage facilities') ||
                    User::userIsAllowedTo('Remove facility')) {
                echo "&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;";
                echo Html::a('<i class="fas fa-trash fa-2x"></i>', ['delete', 'id' => $model->id], [
                    'title' => 'Remove facility',
                    'data-placement' => 'top',
                    'data-toggle' => 'tooltip',
                    'data' => [
                        'confirm' => 'Are you sure you want to delete facility: ' . $model->name . '?<br>'
                        . 'Facility will only be removed if it is not being used by the system!',
                        'method' => 'post',
                    ],
                ]);
            }
            ?>
        </h3>

        <div class="card-tools">
            <table style="margin-top: 0px;">
                <tr><td class="text-sm">Average Facility rating: <?= $rating ?> </td><td>
                        <?php
                        echo StarRating::widget([
                            'name' => 'facility_rating',
                            'value' => $rating,
                            'pluginOptions' => [
                                'min' => 0,
                                'max' => 5,
                                'step' => 1,
                                'size' => 'xsm',
                                'showClear' => false,
                                'showCaption' => true,
                                'displayOnly' => true,
                                'starCaptions' => [
                                    0 => 'Not rated',
                                    1 => 'Very Poor',
                                    2 => 'Poor',
                                    3 => 'Average',
                                    4 => 'Good',
                                    5 => 'Very Good',
                                ],
                                'starCaptionClasses' => [
                                    0 => 'text-danger',
                                    1 => 'text-danger',
                                    2 => 'text-warning',
                                    3 => 'text-info',
                                    4 => 'text-primary',
                                    5 => 'text-success',
                                ],
                            ],
                        ]);
                        ?>

                    </td></tr>
            </table>
        </div>
    </div>
    <div class="card-body">

        <?php
        //This is a hack, just to use pjax for the delete confirm button
        $query = User::find()->where(['id' => '-2']);
        $dataProvider = new \yii\data\ActiveDataProvider([
            'query' => $query,
        ]);
        GridView::widget([
            'dataProvider' => $dataProvider,
        ]);
        ?>

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
                                        // 'name',
                                        //'number_of_beds',
                                        //  'number_of_cots',
                                        //  'number_of_nurses',
                                        //  'number_of_doctors',
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
                                    //  'star:ntext',
                                    //  'rated:ntext',
                                    //  'rating:ntext',
                                    //  'star:ntext',
                                    //  'rated:ntext',
                                    //  'rating:ntext',
                                    //  'longitude',
                                    //   'latitude',
                                    // 'comment:ntext',
                                    // 'geom',
                                    // 'timestamp',
                                    // 'updated',
                                    // 'slug',
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
                            <div class="col-lg-6">
                                <?=
                                DetailView::widget([
                                    'model' => $model,
                                    'attributes' => [
                                        // 'star:ntext',
                                        //  'rated:ntext',
                                        // 'rating:ntext',
                                        // 'longitude',
                                        // 'latitude',
                                        // 'comment:ntext',
                                        // 'geom',
                                        // 'timestamp',
                                        //  'updated',
                                        // 'slug',
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
                                        // 'name',
                                        //  'number_of_beds',
                                        // 'number_of_cots',
                                        //  'number_of_nurses',
                                        // 'number_of_doctors',
                                        //  'star:ntext',
                                        //  'rated:ntext',
                                        //  'rating:ntext',
                                        //  'star:ntext',
                                        //  'rated:ntext',
                                        //  'rating:ntext',
                                        //  'longitude',
                                        //   'latitude',
                                        // 'comment:ntext',
                                        // 'geom',
                                        // 'timestamp',
                                        // 'updated',
                                        // 'slug',
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
                            <div class="col-lg-6">
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
                            <div class="col-md-8"> 
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <p>
                                        <?php
                                        if (User::userIsAllowedTo('Manage facilities') && !empty(\backend\models\Operatinghours::getList())) {
                                            echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addOperatingHourModal\').modal(); 
                                     return false;"><i class="fa fa-plus"></i> Add operating hour</button>';
                                        }
                                        ?>  
                                    </p>
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
                                                ['class' => ActionColumn::className(),
                                                    'template' => '{delete}',
                                                    'buttons' => [
                                                        'delete' => function ($url, $facility_operating_hours) {
                                                            if (User::userIsAllowedTo('Remove facility')) {
                                                                return Html::a(
                                                                                '<span class="fa fa-trash"></span>', ['/facility/delete-operatinghour', 'id' => $facility_operating_hours->id], [
                                                                            'title' => 'Delete',
                                                                            'data-toggle' => 'tooltip',
                                                                            'data-placement' => 'top',
                                                                            'data' => [
                                                                                'confirm' => 'Are you sure you want to remove operating hour from this facility?',
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
                            <div class="col-md-8"> 
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <p>
                                        <?php
                                        if (User::userIsAllowedTo('Manage facilities') && !empty(\backend\models\FacilityService::getList())) {
                                            echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addNewModal\').modal(); 
                                     return false;"><i class="fa fa-plus"></i> Add service</button>';
                                        }
                                        ?>
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
                                                    'attribute' => 'service_id',
                                                    'filter' => false,
                                                    'value' => function ($facility_services) {
                                                        return !empty($facility_services->service_id) ? \backend\models\FacilityService::findOne($facility_services->service_id)->name : "";
                                                        ;
                                                    },
                                                ],
                                                [
                                                    'label' => 'Type',
                                                    'filter' => false,
                                                    'value' => function ($facility_services) {
                                                        $type_id = \backend\models\FacilityService::findOne($facility_services->service_id)->category_id;
                                                        $type = !empty($type_id) ? \backend\models\FacilityServicecategory::findOne($type_id)->name : "";
                                                        return $type;
                                                    },
                                                ],
                                                ['class' => ActionColumn::className(),
                                                    'template' => '{delete}',
                                                    'buttons' => [
                                                        'delete' => function ($url, $facility_services) {
                                                            if (User::userIsAllowedTo('Remove facility')) {
                                                                return Html::a(
                                                                                '<span class="fa fa-trash"></span>', ['/facility/delete-service', 'id' => $facility_services->id], [
                                                                            'title' => 'Delete',
                                                                            'data-toggle' => 'tooltip',
                                                                            'data-placement' => 'top',
                                                                            'data' => [
                                                                                'confirm' => 'Are you sure you want to remove this service from this facility?',
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
                            <div class="col-md-8"> 
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <p>
                                        <?php
                                        if (User::userIsAllowedTo('Manage facilities') &&
                                                !empty(\backend\models\MFLInfrastructure::getList())) {
                                            echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addinfrastructureModal\').modal(); 
                                     return false;"><i class="fa fa-plus"></i> Add Infrastructure</button>';
                                        }
                                        ?>
                                    </p>
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
                                                ['class' => ActionColumn::className(),
                                                    'template' => '{delete}',
                                                    'buttons' => [
                                                        'delete' => function ($url, $facility_infrastructure) {
                                                            if (User::userIsAllowedTo('Remove facility')) {
                                                                return Html::a(
                                                                                '<span class="fa fa-trash"></span>', ['/facility/delete-infrastructure', 'id' => $facility_infrastructure->id], [
                                                                            'title' => 'Delete',
                                                                            'data-toggle' => 'tooltip',
                                                                            'data-placement' => 'top',
                                                                            'data' => [
                                                                                'confirm' => 'Are you sure you want to remove this infrastructure from this facility?',
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
                            <div class="col-md-8"> 
                                <!-- /.card-header -->
                                <div class="card-body p-0">
                                    <p>
                                        <?php
                                        if (User::userIsAllowedTo('Manage facilities') &&
                                                !empty(\backend\models\Equipment::getList())) {
                                            echo '<button class="btn btn-primary btn-sm" href="#" onclick="$(\'#addEquipmentModal\').modal(); 
                                     return false;"><i class="fa fa-plus"></i> Add Equipment</button>';
                                        }
                                        ?>
                                    </p>
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
                                                ['class' => ActionColumn::className(),
                                                    'template' => '{delete}',
                                                    'buttons' => [
                                                        'delete' => function ($url, $facility_equipment) {
                                                            if (User::userIsAllowedTo('Remove facility')) {
                                                                return Html::a(
                                                                                '<span class="fa fa-trash"></span>', ['/facility/delete-equipment', 'id' => $facility_equipment->id], [
                                                                            'title' => 'Delete',
                                                                            'data-toggle' => 'tooltip',
                                                                            'data-placement' => 'top',
                                                                            'data' => [
                                                                                'confirm' => 'Are you sure you want to remove this equipment from this facility?',
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

<div class="modal fade card-primary card-outline" id="addOperatingHourModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Operating hour for facility: <?= $model->name ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $ophour_model = new backend\models\MFLFacilityOperatingHours();
                        $form = ActiveForm::begin([
                                    'action' => 'operatinghour',
                                ])
                        ?>
                        <?=
                        $form->field($ophour_model, 'facility_id')->hiddenInput(['value' => $model->id])->label(false);
                        ?>
                        <?=
                                $form->field($ophour_model, 'operatinghours_id', ['enableAjaxValidation' => true])
                                ->dropDownList(
                                        \backend\models\Operatinghours::getList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Select operating hour', 'required' => true]
                        );
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
                <?= Html::submitButton('Add Operating hour', ['class' => 'btn btn-primary btn-sm']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade card-primary card-outline" id="addNewModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Service for facility: <?= $model->name ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $service_model = new backend\models\MFLFacilityServices();
                        $form = ActiveForm::begin([
                                    'action' => 'services',
                                ])
                        ?>
                        <?=
                        $form->field($service_model, 'facility_id')->hiddenInput(['value' => $model->id])->label(false);
                        ?>
                        <?=
                                $form->field($service_model, 'service_id', ['enableAjaxValidation' => true])
                                ->dropDownList(
                                        \backend\models\FacilityService::getList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Select Service', 'required' => true]
                        );
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
                <?= Html::submitButton('Add service', ['class' => 'btn btn-primary btn-sm']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade card-primary card-outline" id="addinfrastructureModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add Infrastructure for facility: <?= $model->name ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $infra_model = new backend\models\MFLFacilityInfrastructure();
                        $form = ActiveForm::begin([
                                    'action' => 'infrastructure',
                                ])
                        ?>
                        <?=
                        $form->field($infra_model, 'facility_id')->hiddenInput(['value' => $model->id])->label(false);
                        ?>
                        <?=
                                $form->field($infra_model, 'infrastructure_id', ['enableAjaxValidation' => true])
                                ->dropDownList(
                                        \backend\models\MFLInfrastructure::getList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Select Infrastructure', 'required' => true]
                        );
                        ?>
                        <?=
                        $form->field($infra_model, 'value')->textInput(['maxlength' => true, 'placeholder' =>
                            'Enter value i.e 2, Good,National grid etc', 'id' => "province", 'required' => true,])
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
                <?= Html::submitButton('Add Infrastructure', ['class' => 'btn btn-primary btn-sm']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

<div class="modal fade card-primary card-outline" id="addEquipmentModal">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add equipment for facility: <?= $model->name ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-8">
                        <?php
                        $equip_model = new \backend\models\MFLFacilityEquipment();
                        $form = ActiveForm::begin([
                                    'action' => 'equipment',
                                ])
                        ?>
                        <?=
                        $form->field($equip_model, 'facility_id')->hiddenInput(['value' => $model->id])->label(false);
                        ?>
                        <?=
                                $form->field($equip_model, 'equipment_id', ['enableAjaxValidation' => true])
                                ->dropDownList(
                                        \backend\models\Equipment::getList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Select equipment', 'required' => true]
                        );
                        ?>
                        <?=
                        $form->field($equip_model, 'value')->textInput(['maxlength' => true, 'placeholder' =>
                            'Enter value i.e 2,Good etc', 'id' => "province", 'required' => true,])
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
                <?= Html::submitButton('Add Infrastructure', ['class' => 'btn btn-primary btn-sm']) ?>
                <?php ActiveForm::end() ?>
            </div>
        </div>
        <!-- /.modal-content -->
    </div>
    <!-- /.modal-dialog -->
</div>

