<?php

return [
    'id' => 'mfl-app',
    'name' => 'MFL',
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm' => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'timeZone' => 'Africa/Lusaka',
    'components' => [
        'assetManager' => [
            'bundles' => [
                'dosamigos\google\maps\MapAsset' => [
                    'options' => [
                       // 'key' => 'AIzaSyDse73j9ooUEdUlbCf4xcNmeMKgfZiKRSs',
                        'key' => 'AIzaSyB6G0OqzcLTUt1DyYbWFbK4MPUbi1mSCSc',
                        'language' => 'eng',
                        'version' => '3.1.18'
                    ]
                ],
                'kartik\form\ActiveFormAsset' => [
                    'bsDependencyEnabled' => false // do not load bootstrap assets for a specific asset bundle
                ],
            ]
        ],
        'cache' => [
            'class' => 'yii\caching\MemCache',
            'servers' => [
                [
                    'host' => '127.0.0.1',
                    'port' => 11211,
                    'weight' => 100,
                ],
            ],
            'useMemcached' => true,
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
        ],
    ],
    'modules' => [
        'dynagrid' => [
            'class' => '\kartik\dynagrid\Module',
        ],
        'gridview' => [
            'class' => '\kartik\grid\Module'
        ],
        'redactor' => 'yii\redactor\RedactorModule',
    ],
];
