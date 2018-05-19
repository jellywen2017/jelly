<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params-local.php',
    require __DIR__ . '/params-local.php'
);
return [
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JV5RirLx_fsvpJLpqeA_44-lnVqJStwG',
        ],
    ],
    'params' => $params,
];
