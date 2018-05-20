<?php


$config = [];


$components = [];

$components_merge = array_merge(
    $components,
    require __DIR__ . '/main-important.php'
);

$config['components']=$components_merge;

return $config;

