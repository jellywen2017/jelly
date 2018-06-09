<?php
return [
    'aliases' => [
        '@bower' => '@vendor/bower-asset',
        '@npm'   => '@vendor/npm-asset',
    ],
    'vendorPath' => dirname(dirname(__DIR__)) . '/vendor',
    'modules' => [
        'backup' => [
            'class' => 'yiier\backup\Module',
        ],
    ],
    'components' => [
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'assetManager' => [
            'linkAssets' => true,
        ],
        'authManager' => [
            'class' => 'yii\rbac\DbManager', // or use 'yii\rbac\DbManager'
        ]
    ],
];
