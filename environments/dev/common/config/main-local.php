<?php


$config = [];


$components = [];

$components_merge = array_merge(
    $components,
    require __DIR__ . '/params-important.php'
);

$config['components']=$components_merge;

return $config;

