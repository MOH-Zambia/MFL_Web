<?php

use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\number\NumberControl;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Districts */
/* @var $form yii\widgets\ActiveForm */
?>

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
    </div>

    <div class="col-lg-8">
        <?php
        echo $form->field($model, 'geom')->hiddenInput(['id' => "edit-json", 'name' => "geom"])->label("Geometry Coordinates");
        ?>
        <div id="map" style="width: 800px; height: 600px"></div>
        <p id="save"></p>
    </div>

    <?php ActiveForm::end(); ?>

</div>
<script>
if ("<?= 0 ?>")

var map = L.map('map').setView([-13.445529118205, 28.983639375], 6);

L.tileLayer('//{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
        attribution: '&copy; MoH-MFL, <a href="http://osm.org/copyright">OpenStreetMap</a>; contributors'
}).addTo(map);

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

</script>


<script> // Add a save button if we are in PHP
        document.getElementById("save").innerHTML = '<div class="row"><div class="modal-footer justify-content-between col-lg-12">\n\
    <input type="submit" name="post" form="postform" id="save" value="Save District" class="btn btn-primary btn-sm" />\n\
</div></div>';
</script>
