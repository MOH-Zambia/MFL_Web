<?php
/* @var $this yii\web\View */

use yii\helpers\Html;
use backend\models\User;

$this->title = 'Home';
$this->params['breadcrumbs'][] = $this->title;
//GRZ Facilities
$_grz_count = 0;
$_grz_own_model = backend\models\FacilityOwnership::find()->cache(Yii::$app->params['cache_duration'])
                ->where(['LIKE', 'name', "GRZ"])->one();
$_grz_own_id = !empty($_grz_own_model) ? $_grz_own_model->id : "";
if (!empty($_grz_own_id)) {
    $_grz_count = backend\models\MFLFacility::find()
            ->cache(Yii::$app->params['cache_duration'])
            ->where(['ownership_id' => $_grz_own_id])
            ->count();
}
//Hospitals
//1. Get hospital facility type like %Hospital%
$_hosp_type_model = backend\models\Facilitytype::find()
                ->cache(Yii::$app->params['cache_duration'])
                ->where(['LIKE', 'name', "Hospital - Level"])->all();
$_hospital_ids = [];

if (!empty($_hosp_type_model)) {
    foreach ($_hosp_type_model as $_type) {
        array_push($_hospital_ids, $_type['id']);
    }
}

//2.Get all facilities of hospital type
$_hospital_count = 0;
if (!empty($_hospital_ids)) {
    $_hospital_count = backend\models\MFLFacility::find()
            ->cache(Yii::$app->params['cache_duration'])
            ->where(['IN', 'facility_type_id', $_hospital_ids])
            ->count();
}

// Urban Health Centres 
//1. Get hospital facility type like %Urban Health Centres %
$_urban_health_type_model = backend\models\Facilitytype::find()
                ->cache(Yii::$app->params['cache_duration'])
                ->where(['LIKE', 'name', "Urban Health Centre"])->all();
$_urban_health_ids = [];
if (!empty($_urban_health_type_model)) {
    foreach ($_urban_health_type_model as $_type) {
        array_push($_urban_health_ids, $_type['id']);
    }
}

//2.Get all facilities of Urban Health Centres type
$_urban_health_count = 0;
if (!empty($_urban_health_ids)) {
    $_urban_health_count = backend\models\MFLFacility::find()
            ->cache(Yii::$app->params['cache_duration'])
            ->where(['IN', 'facility_type_id', $_urban_health_ids])
            ->count();
}

// Rural Health Centre 
//1. Get hospital facility type like %Rural Health Centre%
$_rural_health_type_model = backend\models\Facilitytype::find()
                ->cache(Yii::$app->params['cache_duration'])
                ->where(['LIKE', 'name', "Rural Health Centre"])->all();
$_rural_health_ids = [];
if (!empty($_rural_health_type_model)) {
    foreach ($_rural_health_type_model as $_type) {
        array_push($_rural_health_ids, $_type['id']);
    }
}

//2.Get all facilities of Urban Health Centres type
$_rural_health_count = 0;
if (!empty($_rural_health_ids)) {
    $_rural_health_count = backend\models\MFLFacility::find()
            ->cache(Yii::$app->params['cache_duration'])
            ->where(['IN', 'facility_type_id', $_rural_health_ids])
            ->count();
}

//  Health Posts
//1. Get hospital facility type like % Health Posts%
$_health_post_type_model = backend\models\Facilitytype::find()
                ->cache(Yii::$app->params['cache_duration'])
                ->where(['LIKE', 'name', "Health Post"])->all();
$_health_post_ids = [];
if (!empty($_health_post_type_model)) {
    foreach ($_health_post_type_model as $_type) {
        array_push($_health_post_ids, $_type['id']);
    }
}

//2.Get all facilities of Health Post type
$_health_post_count = 0;
if (!empty($_health_post_ids)) {
    $_health_post_count = backend\models\MFLFacility::find()
            ->cache(Yii::$app->params['cache_duration'])
            ->where(['IN', 'facility_type_id', $_health_post_ids])
            ->count();
}
// Private
//1. Get hospital facility type like %Private%
$_private_type_model = backend\models\Facilitytype::find()
                ->cache(Yii::$app->params['cache_duration'])
                ->where(['LIKE', 'name', "Private"])->all();
$_private_ids = [];
if (!empty($_private_type_model)) {
    foreach ($_private_type_model as $_type) {
        array_push($_private_ids, $_type['id']);
    }
}

//2.Get all facilities of private
$_private_count = 0;
if (!empty($_private_ids)) {
    $_private_count = backend\models\MFLFacility::find()
            ->cache(Yii::$app->params['cache_duration'])
            ->where(['IN', 'facility_type_id', $_private_ids])
            ->count();
}
?>
<!-- /.row -->
<div class="container-fluid">
    <div class="row">
        <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-info">
                <span class="info-box-icon"><i class="far fa-hospital"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number"> <?= $_grz_count ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width:100%"></div>
                    </div>
                    <span class="progress-description text-sm">
                        Public Facilities
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-success">
                <span class="info-box-icon"><i class="fas fa-hospital-symbol"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number"><?= $_hospital_count ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description text-sm">
                        Hospitals
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-warning">
                <span class="info-box-icon"><i class="fas fa-hospital-alt"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number"><?= $_urban_health_count ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description text-sm">
                       Urban Health Centres
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-danger">
                <span class="info-box-icon"><i class="fas fa-house-damage"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number"><?= $_rural_health_count ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description text-sm">
                        Rural Health Centres
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-gradient-teal">
                <span class="info-box-icon"><i class="fas fa-h-square"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number"><?= $_health_post_count ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description text-sm">
                        Health Posts
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
        <!-- /.col -->
        <div class="col-md-2 col-sm-6 col-12">
            <div class="info-box bg-gradient-indigo">
                <span class="info-box-icon"><i class="fas fa-hashtag"></i></span>

                <div class="info-box-content">
                    <span class="info-box-number"><?= $_private_count ?></span>

                    <div class="progress">
                        <div class="progress-bar" style="width: 100%"></div>
                    </div>
                    <span class="progress-description text-sm">
                       Private
                    </span>
                </div>
                <!-- /.info-box-content -->
            </div>
            <!-- /.info-box -->
        </div>
        <!-- /.col -->
    </div>
</div>

