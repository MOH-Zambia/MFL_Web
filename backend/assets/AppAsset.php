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
        'css/adminlte.min.css',
       // 'leaflet/leaflet.css',
       // 'leaflet/leaflet.draw.css',
    ];
    public $js = [
       // 'js/bootstrap.bundle.min.js',
        'js/adminlte.min.js',
        //'js/demo.js',
        'js/bootstrap-notify.js',
      //  'leaflet/leaflet-src.js',
      //  'leaflet/leaflet.draw-src.js',
       // 'leaflet/leaflet.geometryutil.js',
      //  'leaflet/leaflet.snap.js',
       // 'leaflet/togeojson.js',
       // 'leaflet/leaflet.filelayer.js',
       // 'leaflet/Control.Draw.Plus.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap4\BootstrapAsset',
        'yii\bootstrap4\BootstrapPluginAsset',
    ];
}
