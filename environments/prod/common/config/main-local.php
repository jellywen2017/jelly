<?php


$config = [];


$components = [];

$components_merge = array_merge(
    $components,
    require __DIR__ . '/main-important.php'
);

$config['components']=$components_merge;

$config['bootstrap'][] = 'debug';
$config['modules']['debug'] = [
    'class' => 'yii\debug\Module',
    'allowedIPs' => ['127.0.0.1', '::1', '58.34.27.240'],
];

$config['bootstrap'][] = 'gii';
$config['modules']['gii'] = [
    'class' => 'yii\gii\Module',
    'allowedIPs' => ['127.0.0.1', '::1', '58.34.27.240'],
];

return $config;

