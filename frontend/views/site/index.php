<?php

use yii\helpers\Html;
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
use kartik\depdrop\DepDrop;
use kartik\form\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
$this->title = 'Home';
$connection = Yii::$app->getDb();
//Get all provinces data
$provinces_model = \backend\models\Provinces::find()
        ->cache(Yii::$app->params['cache_duration'])
        ->select(['id', 'name', 'population', 'pop_density', 'area_sq_km', 'ST_AsGeoJSON(geom) as geom'])
        ->all();

/**
 * 
 * Data for Pie/Bar chart by Facility type
 * 
 */
$pie_series = [];
$column_series = [];
$data = [];
$data1 = [];
$labels = [];
$opstatus_id = "";
$facility_model = "";
//We assume facility operation status name "Operational" 
//will never be renamed/deleted otherwise the system breaks
$operation_status_model = \backend\models\Operationstatus::findOne(['name' => "Operational"]);
if (!empty($operation_status_model)) {
    $opstatus_id = $operation_status_model->id;
//We get facilities by operating status and type
    $facility_model = backend\models\MFLFacility::find()->cache(Yii::$app->params['cache_duration'])
                    ->select(['facility_type_id', 'COUNT(*) AS count'])
                    ->where(['operation_status_id' => $opstatus_id])
                    ->groupBy(['facility_type_id'])
                    ->createCommand()->queryAll();
    foreach ($facility_model as $model) {
        //Push pie data to array
        array_push($data, ['name' => backend\models\Facilitytype::findOne($model['facility_type_id'])->name, 'y' => (int) $model['count'],]);
        //Push column labels to array
        if (!in_array(backend\models\Facilitytype::findOne($model['facility_type_id'])->name, $labels)) {
            array_push($labels, backend\models\Facilitytype::findOne($model['facility_type_id'])->name);
        }
        //We push column data to array
        array_push($data1, (int) $model['count']);
    }
    //We push pie plot details to the series
    array_push($pie_series, ['name' => 'Total', 'colorByPoint' => true, 'data' => $data]);
    array_push($column_series, ['name' => "Total", 'data' => $data1]);
}

/**
 * 
 * Data for Pie/Bar chart by Province
 * 
 */
$pie_series1 = [];
$column_series1 = [];
$data2 = [];
$data3 = [];
$labels1 = [];
if (!empty($operation_status_model)) {
    $province_counts = $connection->cache(function ($connection) use ($operation_status_model) {
        return $connection->createCommand('select count(f.id) as count,p.name from public."MFL_facility" f INNER JOIN 
public."geography_district" d ON f.district_id=d.id INNER JOIN
public."geography_province" p ON d.province_id=p.id INNER JOIN
public."MFL_operationstatus" ops ON f.operation_status_id=ops.id
WHERE ops.id=' . $operation_status_model->id . '
group by p.name Order by p.name')->queryAll();
    });

    foreach ($province_counts as $model) {
        //Push pie data to array
        array_push($data2, ['name' => $model['name'], 'y' => (int) $model['count'],]);
        //Push column labels to array
        if (!in_array($model['name'], $labels1)) {
            array_push($labels1, $model['name']);
        }
        //We push column data to array
        array_push($data3, (int) $model['count']);
    }
    //We push pie plot details to the series
    array_push($pie_series1, ['name' => 'Total', 'colorByPoint' => true, 'data' => $data2]);
    array_push($column_series1, ['name' => "Total", 'data' => $data3]);
}
?>
<div class="container-fluid">
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#revenue-chart" data-toggle="tab">Pie</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" href="#sales-chart" data-toggle="tab">Bar</a>
                            </li>
                        </ul>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane active" id="revenue-chart"
                             style="height: auto;">
                                 <?=
                                 \dosamigos\highcharts\HighCharts::widget([
                                     'clientOptions' => [
                                         'chart' => [
                                             'plotBackgroundColor' => null,
                                             'plotBorderWidth' => null,
                                             'plotShadow' => false,
                                             'type' => 'pie',
                                         ],
                                         'title' => [
                                             'text' => 'Operating Facilities by type'
                                         ],
                                         'tooltip' => [
                                             'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>'
                                         ],
                                         [
                                             'accessibility' => [
                                                 'point' => [
                                                     'valueSuffix' => '%'
                                                 ]
                                             ],
                                         ],
                                         'plotOptions' => [
                                             'pie' => [
                                                 'allowPointSelect' => true,
                                                 'cursor' => 'pointer',
                                                 'size' => '70%',
                                                 'height' => '100%',
                                                 'dataLabels' => [
                                                     'enabled' => true,
                                                     'style' => [
                                                         'fontSize' => 5
                                                     ],
                                                     'format' => '{point.name}',
                                                 //'format' => '{point.name}: {point.percentage:.1f} %',
                                                 ],
                                                 'showInLegend' => false
                                             ]
                                         ],
                                         'series' =>
                                         $pie_series
                                     ]
                                 ]);
                                 ?>
                        </div>
                        <div class="chart tab-pane" id="sales-chart" 
                             style="position: relative; height: auto;">
                                 <?=
                                 \dosamigos\highcharts\HighCharts::widget([
                                     'clientOptions' => [
                                         'chart' => [
                                             'plotBackgroundColor' => null,
                                             'plotBorderWidth' => null,
                                             'plotShadow' => false,
                                             'type' => 'column'
                                         ],
                                         'legend' => [
                                             'enabled' => false
                                         ],
                                         'plotOptions' => [
                                             'column' => [
                                                 'allowPointSelect' => true,
                                                 'colorByPoint' => true,
                                                 'cursor' => 'pointer',
                                                 'dataLabels' => [
                                                     'enabled' => true,
                                                     'style' => [
                                                         'fontSize' => 5
                                                     ],
                                                 ],
                                             ]
                                         ],
                                         'title' => [
                                             'text' => 'Operating Facilities by type'
                                         ],
                                         'xAxis' => [
                                             'categories' => $labels
                                         ],
                                         'yAxis' => [
                                             'title' => [
                                                 'text' => 'Count'
                                             ]
                                         ],
                                         'series' => $column_series
                                     ]
                                 ]);
                                 ?>                       
                        </div>  
                    </div>
                </div><!-- /.card-body -->
            </div>
        </div>
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header">
                    <div class="card-tools">
                        <ul class="nav nav-pills ml-auto">
                            <li class="nav-item">
                                <a class="nav-link active" href="#bar-chart" data-toggle="tab">Bar</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link " href="#pie-chart" data-toggle="tab">Pie</a>
                            </li>

                        </ul>
                    </div>
                </div><!-- /.card-header -->
                <div class="card-body">
                    <div class="tab-content p-0">
                        <!-- Morris chart - Sales -->
                        <div class="chart tab-pane " id="pie-chart"
                             style="height: auto;">
                                 <?=
                                 \dosamigos\highcharts\HighCharts::widget([
                                     'clientOptions' => [
                                         'chart' => [
                                             'plotBackgroundColor' => null,
                                             'plotBorderWidth' => null,
                                             'plotShadow' => false,
                                             'type' => 'pie',
                                         ],
                                         'title' => [
                                             'text' => 'Operating Facilities by Province'
                                         ],
                                         'tooltip' => [
                                             'pointFormat' => '{series.name}: <b>{point.percentage:.1f}%</b>'
                                         ],
                                         [
                                             'accessibility' => [
                                                 'point' => [
                                                     'valueSuffix' => '%'
                                                 ]
                                             ],
                                         ],
                                         'plotOptions' => [
                                             'pie' => [
                                                 'allowPointSelect' => true,
                                                 'cursor' => 'pointer',
                                                 'size' => '70%',
                                                 'height' => '100%',
                                                 'dataLabels' => [
                                                     'enabled' => true,
                                                     'style' => [
                                                         'fontSize' => 5
                                                     ],
                                                     'format' => '{point.name}',
                                                 //'format' => '{point.name}: {point.percentage:.1f} %',
                                                 ],
                                                 'showInLegend' => false
                                             ]
                                         ],
                                         'series' =>
                                         $pie_series1
                                     ]
                                 ]);
                                 ?>
                        </div>
                        <div class="chart tab-pane active" id="bar-chart" 
                             style="position: relative; height: auto;">
                                 <?=
                                 \dosamigos\highcharts\HighCharts::widget([
                                     'clientOptions' => [
                                         'chart' => [
                                             'plotBackgroundColor' => null,
                                             'plotBorderWidth' => null,
                                             'plotShadow' => false,
                                             'type' => 'column'
                                         ],
                                         'legend' => [
                                             'enabled' => false
                                         ],
                                         'plotOptions' => [
                                             'column' => [
                                                 'allowPointSelect' => true,
                                                 'colorByPoint' => true,
                                                 'cursor' => 'pointer',
                                                 'dataLabels' => [
                                                     'enabled' => true,
                                                     'style' => [
                                                         'fontSize' => 5
                                                     ],
                                                 ],
                                             ]
                                         ],
                                         'title' => [
                                             'text' => 'Operating Facilities by Province'
                                         ],
                                         'xAxis' => [
                                             'categories' => $labels1
                                         ],
                                         'yAxis' => [
                                             'title' => [
                                                 'text' => 'Count'
                                             ]
                                         ],
                                         'series' => $column_series1
                                     ]
                                 ]);
                                 ?>                       
                        </div>  
                    </div>
                </div><!-- /.card-body -->
            </div>
        </div>
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-8">
                            <p></p>
                            <?php
                            $filter_str = "Search results for: ";
                            $counter = 0;
                            $colors = ["#ed5151", "#149ece", "#a7c636", "#9e559c", "#fc921f", "purple", "#006D2C", ' #2a4858', '#fafa6e', 'lime'];
                            $coord = new LatLng([
                                'lat' => -13.445529118205,
                                'lng' => 28.983639375
                            ]);

                            $map = new Map([
                                'center' => $coord,
                                'zoom' => Yii::$app->params['polygon_zoom'],
                                'width' => '100%', 'height' => 500,
                            ]);

                            //Show the filter parameters
                            if (isset($_GET['MFLFacility']) && $dataProvider->getTotalCount() > 0) {
                                if (!empty($_GET['MFLFacility']['province_id']) ||
                                        !empty($_GET['MFLFacility']['ownership_id']) ||
                                        !empty($_GET['MFLFacility']['facility_type_id']) ||
                                        !empty($_GET['MFLFacility']['name']) ||
                                        !empty($_GET['MFLFacility']['district_id'])) {
                                    $_province = !empty($_GET['MFLFacility']['province_id']) ? \backend\models\Provinces::findOne($_GET['MFLFacility']['province_id'])->name : "";
                                    $_district = !empty($_GET['MFLFacility']['district_id']) ? \backend\models\Districts::findOne($_GET['MFLFacility']['district_id'])->name : "";
                                    $_facility_type = !empty($_GET['MFLFacility']['facility_type_id']) ? \backend\models\Facilitytype::findOne($_GET['MFLFacility']['facility_type_id'])->name : "";
                                    $_ownership = !empty($_GET['MFLFacility']['ownership_id']) ? \backend\models\FacilityOwnership::findOne($_GET['MFLFacility']['ownership_id'])->name : "";
                                    $prov_str = !empty($_province) ? "Province:" . $_province . " | " : "";
                                    $dist_str = !empty($_district) ? "District:" . $_district . " | " : "";
                                    $fac_str = !empty($_facility_type) ? "Facility type:" . $_facility_type . " | " : "";
                                    $own_str = !empty($_ownership) ? "Ownship:" . $_ownership : "";
                                    $name_str = !empty($_GET['MFLFacility']['name']) ? "Facility name:" . $_GET['MFLFacility']['name'] . "|" : "";
                                    $filter_str .= "<i>" . $name_str . "</i><i>" . $prov_str . "</i><i>" . $dist_str . "</i><i>"
                                            . $fac_str . "</i><i>" . $own_str . "</I>";
                                    echo "<p class='text-sm'>$filter_str</p>";
                                }
                            }
                            if (isset($_GET['MFLFacility']) && $dataProvider->getTotalCount() == 0) {
                                echo "<p class='text-sm'>No search results were found!</p>";
                            }

                            //We make sure that the filter form maintains the filter values
                            if (isset($_GET['MFLFacility']['province_id']) &&
                                    !empty($_GET['MFLFacility']['province_id'])) {
                                $MFLFacility_model->province_id = $_GET['MFLFacility']['province_id'];
                            }
                            if (isset($_GET['MFLFacility']['ownership_id']) &&
                                    !empty($_GET['MFLFacility']['ownership_id'])) {
                                $MFLFacility_model->ownership_id = $_GET['MFLFacility']['ownership_id'];
                            }
                            if (isset($_GET['MFLFacility']['facility_type_id']) &&
                                    !empty($_GET['MFLFacility']['facility_type_id'])) {
                                $MFLFacility_model->facility_type_id = $_GET['MFLFacility']['facility_type_id'];
                            }
                            if (isset($_GET['MFLFacility']['name']) &&
                                    !empty($_GET['MFLFacility']['name'])) {
                                $MFLFacility_model->name = $_GET['MFLFacility']['name'];
                            }
                            /* if (isset($_GET['MFLFacility']['district_id']) &&
                              !empty($_GET['MFLFacility']['district_id'])) {
                              $MFLFacility_model->district_id = $_GET['MFLFacility']['district_id'];
                              } */
                            if ($dataProvider !== "" && $dataProvider->getTotalCount() > 0) {
                                $dataProvider_models = $dataProvider->getModels();
                                foreach ($provinces_model as $model) {
                                    if (!empty($model->geom)) {
                                        //We pick a color for each province polygon
                                        $stroke_color = $colors[$counter];
                                        $counter++;

                                        $coords = \backend\models\Provinces::getCoordinates(json_decode($model->geom, true)['coordinates']);

                                        $polygon = new Polygon([
                                            'paths' => $coords,
                                            'strokeColor' => $stroke_color,
                                            'strokeOpacity' => 0.8,
                                            'strokeWeight' => 2,
                                            'fillColor' => $stroke_color,
                                            'fillOpacity' => 0.35,
                                        ]);
                                        //We get all districts in the province
                                        $districts_model = backend\models\Districts::find()->cache(Yii::$app->params['cache_duration'])
                                                ->where(['province_id' => $model->id])
                                                ->all();
                                        //We create an array to be used to get the facilities in the province
                                        $district_ids = [];
                                        if (!empty($districts_model)) {
                                            foreach ($districts_model as $id) {
                                                array_push($district_ids, $id['id']);
                                            }
                                        }

                                        //We now get the facilities in the province
                                        $facilities_counts = backend\models\MFLFacility::find()
                                                        ->cache(Yii::$app->params['cache_duration'])
                                                        ->select(["COUNT(*) as count", "facility_type_id"])
                                                        ->where(['operation_status_id' => $opstatus_id])
                                                        ->andWhere(['IN', 'district_id', $district_ids])
                                                        ->groupBy(['facility_type_id'])
                                                        ->createCommand()->queryAll();

                                        //We build the window string
                                        $type_str = "";
                                        foreach ($facilities_counts as $f_model) {
                                            $facility_type = !empty($f_model['facility_type_id']) ? backend\models\Facilitytype::findOne($f_model['facility_type_id'])->name : "";
                                            $type_str .= $facility_type . ":<b>" . $f_model['count'] . "</b><br>";
                                        }
                                        $polygon->attachInfoWindow(new InfoWindow([
                                                    'content' => '<p><strong><span class="text-center">' . $model->name . ' Province Facility types</span></strong><hr>'
                                                    . $type_str . '</p>'
                                        ]));

                                        $map->addOverlay($polygon);

                                        foreach ($dataProvider_models as $_model) {
                                            // var_dump($_model);
                                            if (!empty($_model->latitude) && !empty($_model->longitude)) {
                                                $coord = new LatLng(['lat' => $_model->latitude, 'lng' => $_model->longitude]);
                                                $marker = new Marker([
                                                    'position' => $coord,
                                                    'title' => $_model->name,
                                                    'icon' => \yii\helpers\Url::to('@web/img/map_icon.png')
                                                ]);

                                                $constituency = !empty($_model->constituency_id) ? backend\models\Constituency::findOne($_model->constituency_id)->name : "";
                                                $ward = !empty($_model->ward_id) ? backend\models\Wards::findOne($_model->ward_id)->name : "";
                                                $loc_type = !empty($_model->location_type_id) ? backend\models\LocationType::findOne($_model->location_type_id)->name : "";
                                                $type = !empty($_model->facility_type_id) ? backend\models\Facilitytype::findOne($_model->facility_type_id)->name : "";
                                                $ownership = !empty($_model->ownership_id) ? backend\models\FacilityOwnership::findOne($_model->ownership_id)->name : "";
                                                $operation_status = !empty($_model->operation_status_id) ? backend\models\Operationstatus::findOne($_model->operation_status_id)->name : "";
                                                $type_str = "";
                                                $type_str .= "<b>Province: </b>" . \backend\models\Provinces::findOne(backend\models\Districts::findOne($_model->district_id)->province_id)->name . "<br>";
                                                $type_str .= "<b>District: </b>" . backend\models\Districts::findOne($_model->district_id)->name . "<br>";
                                                $type_str .= "<b>Constituency: </b>" . $constituency . "<br>";
                                                $type_str .= "<b>Ward: </b>" . $ward . "<br>";
                                                $type_str .= "<b>Location type: </b>" . $loc_type . "<br>";
                                                $type_str .= "<b>Facility type: </b>" . $type . "<br>";
                                                $type_str .= "<b>Ownership: </b>" . $ownership . "<br>";
                                                $type_str .= "<b>Operation status: </b><span style='color:green;'>" . $operation_status . "</span><br>";
                                                $marker->attachInfoWindow(
                                                        new InfoWindow([
                                                            'content' => '<p><strong><span class="text-center">' . $_model->name . '</span></strong><hr>'
                                                            . $type_str . '</p>'
                                                                ])
                                                );

                                                $map->addOverlay($marker);
                                            }
                                        }
                                    }
                                }

                                echo $map->display();
                            } else {

                                foreach ($provinces_model as $model) {
                                    if (!empty($model->geom)) {
                                        //We pick a color for each province polygon
                                        $stroke_color = $colors[$counter];
                                        $counter++;

                                        $coords = \backend\models\Provinces::getCoordinates(json_decode($model->geom, true)['coordinates']);

                                        $polygon = new Polygon([
                                            'paths' => $coords,
                                            'strokeColor' => $stroke_color,
                                            'strokeOpacity' => 0.8,
                                            'strokeWeight' => 2,
                                            'fillColor' => $stroke_color,
                                            'fillOpacity' => 0.35,
                                        ]);

                                        //We get all districts in the province
                                        $districts_model = backend\models\Districts::find()->cache(Yii::$app->params['cache_duration'])
                                                ->where(['province_id' => $model->id])
                                                ->all();
                                        //We create an array to be used to get the facilities in the province
                                        $district_ids = [];
                                        if (!empty($districts_model)) {
                                            foreach ($districts_model as $id) {
                                                array_push($district_ids, $id['id']);
                                            }
                                        }

                                        //We now get the facilities in the province
                                        $facilities_counts = backend\models\MFLFacility::find()
                                                        ->cache(Yii::$app->params['cache_duration'])
                                                        ->select(["COUNT(*) as count", "facility_type_id"])
                                                        ->where(['operation_status_id' => $opstatus_id])
                                                        ->andWhere(['IN', 'district_id', $district_ids])
                                                        ->groupBy(['facility_type_id'])
                                                        ->createCommand()->queryAll();

                                        //We build the window string
                                        $type_str = "";
                                        foreach ($facilities_counts as $f_model) {
                                            $facility_type = !empty($f_model['facility_type_id']) ? backend\models\Facilitytype::findOne($f_model['facility_type_id'])->name : "";
                                            $type_str .= $facility_type . ":<b>" . $f_model['count'] . "</b><br>";
                                        }
                                        $polygon->attachInfoWindow(new InfoWindow([
                                                    'content' => '<p><strong><span class="text-center">' . $model->name . ' Province Facility types</span></strong><hr>'
                                                    . $type_str . '</p>'
                                        ]));

                                        $map->addOverlay($polygon);
                                    }
                                }

                                echo $map->display();
                            }
                            ?>
                        </div>
                        <div class="col-lg-4 text-sm">
                            <h4>Instructions</h4>
                            <ol>
                                <li>Click province to view facility counts by type</li>
                                <li>A filter below will show actual 
                                    facility locations on the map</li>
                            </ol>
                            <div class="row">

                                <?php
                                $form = ActiveForm::begin([
                                            'action' => ['index'],
                                            'method' => 'GET',
                                ]);
                                ?>
                                <div class="col-lg-12">
                                    <?php
                                    echo $form->field($MFLFacility_model, 'name')->textInput(['maxlength' => true, 'placeholder' =>
                                        'Filter by facility name', 'required' => false,]);
                                    ?>
                                </div>
                                <div class="col-lg-12">
                                    <?php
                                    echo
                                            $form->field($MFLFacility_model, 'province_id')
                                            ->dropDownList(
                                                    \backend\models\Provinces::getProvinceList(), ['id' => 'prov_id', 'custom' => true, 'prompt' => 'Filter by province', 'required' => false]
                                    );
                                    ?>
                                </div>
                                <div class="col-lg-12">
                                    <?php
                                    echo Html::hiddenInput('selected_id', $MFLFacility_model->isNewRecord ? '' : $MFLFacility_model->district_id, ['id' => 'selected_id']);
                                    /* if (isset($_GET['MFLFacility']['province_id']) &&
                                      !empty($_GET['MFLFacility']['province_id'])) {
                                      echo
                                      $form->field($MFLFacility_model, 'district_id')
                                      ->dropDownList(
                                      \backend\models\Districts::getListByProvinceID($_GET['MFLFacility']['province_id']), ['custom' => true, 'prompt' => 'Filter by district', 'required' => false]
                                      ); */
//  } else {
                                    echo $form->field($MFLFacility_model, 'district_id')->widget(DepDrop::classname(), [
                                        'options' => ['id' => 'dist_id', 'custom' => true, 'required' => false],
                                        'type' => DepDrop::TYPE_SELECT2,
                                        'pluginOptions' => [
                                            'depends' => ['prov_id'],
                                            'initialize' => $MFLFacility_model->isNewRecord ? false : true,
                                            'placeholder' => 'Filter by district',
                                            'url' => Url::to(['/site/district']),
                                            'params' => ['selected_id'],
                                            'loadingText' => 'Loading districts....',
                                        ]
                                    ]);
//  }
                                    ?>
                                </div>
                                <div class="col-lg-12">
                                    <?=
                                            $form->field($MFLFacility_model, 'facility_type_id')
                                            ->dropDownList(
                                                    \backend\models\Facilitytype::getList(), ['custom' => true, 'prompt' => 'Filter by facility type', 'required' => false]
                                    );
                                    ?>
                                </div>
                                <div class="col-lg-12">
                                    <?=
                                            $form->field($MFLFacility_model, 'ownership_id')
                                            ->dropDownList(
                                                    \backend\models\FacilityOwnership::getList(), ['custom' => true, 'prompt' => 'Filter by ownership', 'required' => false]
                                    );
                                    ?>
                                </div>
                                <?= Html::submitButton('Filter', ['class' => 'btn btn-primary btn-sm', 'name' => "filter", "value" => "true"]) ?>
                                <?php ActiveForm::end(); ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-lg-12">
            &nbsp;&nbsp;
        </div>
    </div>
</div>

