<?php

$config = [];

$params = array_merge(
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/../../common/config/params-important.php',
    require __DIR__ . '/params-local.php'
);

$components = [];

$components['request'] = [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '8LQmLbgGvD6IW6Jt5KcbEQgcME7bbTy8-lnVqJStwG',
        ];

$config['components']=$components;
$config['params']=$params;

return $config;