<?php

use yii\helpers\Html;
use kartik\depdrop\DepDrop;
use yii\helpers\Url;
use kartik\number\NumberControl;
use kartik\form\ActiveForm;

/* @var $this yii\web\View */
/* @var $model backend\models\Constituency */
/* @var $form yii\widgets\ActiveForm */
if (!empty($model->district_id)) {
    $model->province_id = backend\models\Districts::findOne($model->district_id)->province_id;
}
?>

<div class="constituency-form">

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
</div>
<!-- Insert the javascript after all <div> are defined -->
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
    <input type="submit" name="post" form="postform" id="save" value="Save Constituency" class="btn btn-primary btn-sm" />\n\
</div></div>';
</script>
