<?php
$config = [];

$params = array_merge(
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/../../common/config/params-important.php',
    require __DIR__ . '/params-local.php'
);

$components = [];

$config['components']=$components;
$config['params']=$params;

return $config;