<?php

use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\number\NumberControl;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Wards */
/* @var $form yii\widgets\ActiveForm */
//var_dump($model->geom);
if (!empty($model->district_id)) {
    $model->province_id = backend\models\Districts::findOne($model->district_id)->province_id;
}
?>

<div class="wards-form">

    <div class="row">
        <div class="col-lg-12">
            <h4>Instructions</h4>
            <ol>
                <li>Fields marked with <span style="color: red;">*</span> are required</li>
            </ol>
        </div>
        <div class="col-lg-4">
            <?php
            $form = ActiveForm::begin([
                        // 'action' => 'create',
                        "id" => "postform",
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
            echo Html::hiddenInput('selected_id2', $model->isNewRecord ? '' : $model->district_id, ['id' => 'selected_id2']);

            echo $form->field($model, 'constituency_id')->widget(DepDrop::classname(), [
                'options' => ['id' => 'constituency_id', 'custom' => true, 'required' => false],
                'pluginOptions' => [
                    'depends' => ['dist_id'],
                    'initialize' => $model->isNewRecord ? false : true,
                    'placeholder' => 'Please select a constituency',
                    'url' => Url::to(['/constituencies/constituency']),
                    'params' => ['selected_id2'],
                ]
            ]);
            /* echo Html::hiddenInput('selected_id3', $model->isNewRecord ? '' : $model->district_id, ['id' => 'selected_id3']);

              echo $form->field($model, 'district_id')->widget(DepDrop::classname(), [
              'options' => ['id' => 'ward_id', 'custom' => true, 'required' => TRUE],
              'pluginOptions' => [
              'depends' => ['dist_id'],
              'initialize' => $model->isNewRecord ? false : true,
              'placeholder' => 'Please select a ward',
              'url' => Url::to(['/constituencies/ward']),
              'params' => ['selected_id3'],
              ]
              ]); */
            ?>
            <?=
            $form->field($model, 'name', ['enableAjaxValidation' => true])->textInput(['maxlength' => true, 'placeholder' =>
                'Name of ward', 'required' => true,])
            ?>
            <?=
            $form->field($model, 'population')->widget(NumberControl::classname(), [
                'displayOptions' => [
                    'placeholder' => 'Enter population in the ward'
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
                    'placeholder' => 'Enter population density for the ward'
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
                    'placeholder' => 'Enter size of ward'
                ],
                'maskedInputOptions' => [
                    'suffix' => ' Sq Km',
                    'allowMinus' => false
                ],
            ]);
            ?>

        </div>
        <div class="col-lg-8">
            <?php
            echo $form->field($model, 'geom')->hiddenInput(['id' => "edit-json", 'name' => "geom"])->label("Geometry Coordinates");
            /*  // first lets setup the center of our map
              $center = new \dosamigos\leaflet\types\LatLng(['lat' => -13.445529118205,
              'lng' => 28.983639375]);

              // now lets create a marker that we are going to place on our map
              // $marker = new \dosamigos\leaflet\layers\Marker(['latLng' => $center, 'popupContent' => 'Hi!']);
              // The Tile Layer (very important)
              $tileLayer = new \dosamigos\leaflet\layers\TileLayer([
              'urlTemplate' => 'https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png',
              'clientOptions' => [
              'attribution' => 'Map data © <a href="http://openstreetmap.org">OpenStreetMap</a> contributors'
              // 'attribution' => '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>',
              // 'subdomains' => ['1', '2', '3', '4'],
              ],
              ]);

              // now our component and we are going to configure it
              $leaflet = new \dosamigos\leaflet\LeafLet([
              'center' => $center, // set the center
              'name' => 'map',
              'tileLayer' => $tileLayer,
              'zoom' => Yii::$app->params['polygon_zoom'],

              ]);

              // init the 2amigos leaflet plugin provided by the package
              $drawFeature = new \davidjeddy\leaflet\plugins\draw\Draw();
              // optional config array for leadlet.draw
              $drawFeature->options = [
              "position" => "topright",
              "draw" => [
              'polyline' => false,
              'rectangle' => false,
              'circle' => false,
              'circlemarker' => false,
              'marker' => false,
              "polyline" => [
              "shapeOptions" => [
              "color" => "#ff0000",
              "weight" => 10
              ]
              ],
              "polygon" => [
              "allowIntersection" => false, // Restricts shapes to simple polygons
              "drawError" => [
              "color" => Yii::$app->params['polygon_strokeColor'], // Color the shape will turn when intersects
              "message" => "<b>Oh snap!</b> you can't draw that!" // Message that will show when intersect
              ],
              "shapeOptions" => [
              "color" => Yii::$app->params['polygon_strokeColor']
              ]
              ],
              "circle" => false, // Turns off this drawing tool
              /* "rectangle" => [
              "shapeOptions" => [
              "clickable" => false
              ]
              ]
              ]
              ];

              // Different layers can be added to our map using the `addLayer` function.
              $leaflet->addLayer($tileLayer)             // add the marker
              //  ->addLayer( $marker)          // add the tile layer
              ->installPlugin($drawFeature);  // add draw plugin
              // we could also do
              echo $leaflet->widget(['options' => ['style' => 'min-height: 500px']]);
             */
            ?>
            <div id="map" style="width: 800px; height: 600px"></div>
            <p id="save"></p>
        </div>
        <div class="modal-footer justify-content-between">
            <?php //Html::submitButton('Save Constituency', ['class' => 'btn btn-primary btn-sm',"name"=>"post", "id"=>"save"]) ?>
            <?php ActiveForm::end() ?>
        </div>
    </div>
</div>





<!-- Insert the javascript after all <div> are defined -->
<script>
if ("<?= 0 ?>")

var map = L.map('map').setView([-13.445529118205, 28.983639375], 6);

L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; MoH-MFL, <a href="http://osm.org/copyright">OpenStreetMap</a>; contributors'
}).addTo(map);
/*var polyLayers = [];  
var drawnItems = new L.FeatureGroup();
    map.addLayer(drawnItems);*/

//Lets add existing polygon to allow a user to edit or create a new one if they are updating
<?php
/* if (!empty($model->geom)) {
  echo 'var polygon =[';
  //echo 'var latlngs ='. GuzzleHttp\json_encode(json_decode($model->geom, true)['coordinates'][0][0]);
  foreach (json_decode($model->geom, true)['coordinates'][0][0] as $point) {
  echo '[' . $point[1] . "," . $point[0] . "], ";
  }
  echo "];\n";
  } else {
  echo 'var polygon =[];';
  } */
?>    

/*var polygon = L.polygon(polygon, {});
polyLayers.push(polygon)    

for(let layer of polyLayers) {
        drawnItems.addLayer(layer); 
    }
*/

/*L.drawLocal.draw.toolbar.buttons.polygon = 'Draw a sexy polygon!';
        var drawControl = new L.Control.Draw({
        position: 'topright',
        draw: {
            marker: false,
            polyline: false,
            polygon: true,
            circlemarker:false,
            circle:false,
            rectangle:false,
            polygon: {
                    allowIntersection: false,
                    showArea: true,
                    drawError: {
                            color: 'red',
                            timeout: 1000
                    },
                    shapeOptions: {
                            color: 'red'
                    }
            },
        },
        edit: {
                featureGroup: drawnItems,
                remove: true
        },
              entry: 'edit-json'
        });
map.addControl(drawControl);

map.on('draw:created', function (e) {
        var type = e.layerType,
                layer = e.layer;

        if (type === 'marker') {
                layer.bindPopup('A popup!');
        }

        drawnItems.addLayer(layer);
});

map.on('draw:edited', function (e) {
        var layers = e.layers;
        var countOfEditedLayers = 0;
        layers.eachLayer(function(layer) {
                countOfEditedLayers++;
        });
        console.log("Edited " + countOfEditedLayers + " layers");
});
map.on(L.Draw.Event.CREATED, function (e) {
        var type = e.layerType,
            layer = e.layer;
        drawnItems.addLayer(layer);
        console.log('draw:created->');
            console.log(JSON.stringify(layer.toGeoJSON()));
    });*/
var editor = new L.Control.Draw.Plus({
     position: 'topright',
        draw: {
                marker: false,
                polyline: false,
                //polygon: true,
                circlemarker:false,
                polygon: {
                     showArea: true,
                    allowIntersection: false,
                    showArea: true,
                    drawError: {
                            color: 'red',
                            timeout: 1000
                    },
                    shapeOptions: {
                            color: 'red'
                    }
            },
        },
        edit: {
                remove: true,
                edit:true
        },
        entry: 'edit-json'
}).addTo(map);

// File loader
/*var fl = new L.Control.FileLayerLoad().addTo(map);
fl.loader.on('data:loaded', function(e) {
        e.layer.addTo(editor);
}, fl);*/
</script>


<script> // Add a save button if we are in PHP
        document.getElementById("save").innerHTML = '<div class="row"><div class="modal-footer justify-content-between col-lg-12">\n\
    <input type="submit" name="post" form="postform" id="save" value="Save ward" class="btn btn-primary btn-sm" />\n\
</div></div>';
</script>

