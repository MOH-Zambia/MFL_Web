<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
     public $css = [
        //'css/site.css',
        'fontawesome-free/css/all.min.css',
        'css/icheck-bootstrap.min.css',
        'css/adminlte.min.css'
    ];
    public $js = [
       // 'js/bootstrap.bundle.min.js',
        'js/adminlte.min.js',
        //'js/demo.js',
        'js/bootstrap-notify.js'
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
