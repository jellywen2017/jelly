<?php
$params = array_merge(
    require __DIR__ . '/../../common/config/params.php',
    require __DIR__ . '/params.php'
);

return [
    'id' => 'app-backend',
    'name' => '管理后台',
    'basePath' => dirname(__DIR__),
    'controllerNamespace' => 'backend\controllers',
    'bootstrap' => ['log','admin'],
    'modules' => [
        'admin' => [
            'class' => 'mdm\admin\Module',
            // 'layout' => 'main',
            'controllerMap' => [
                 'assignment' => [
                    'class' => 'mdm\admin\controllers\AssignmentController',
                    'userClassName' => 'common\models\User', 
                    'idField' => 'id',
                    'usernameField' => 'username',
                    'fullnameField' => 'email',
                    // 'extraColumns' => [
                    //     [
                    //         'attribute' => 'full_name',
                    //         'label' => 'Full Name',
                    //         'value' => function($model, $key, $index, $column) {
                    //             return $model->profile->full_name;
                    //         },
                    //     ],
                    //     [
                    //         'attribute' => 'dept_name',
                    //         'label' => 'Department',
                    //         'value' => function($model, $key, $index, $column) {
                    //             return $model->profile->dept->name;
                    //         },
                    //     ],
                    //     [
                    //         'attribute' => 'post_name',
                    //         'label' => 'Post',
                    //         'value' => function($model, $key, $index, $column) {
                    //             return $model->profile->post->name;
                    //         },
                    //     ],
                    // ],
                    // 'searchClass' => 'common\models\UserSearch'
                ],
            ],
        ],
        'editor' => [ //富文本编辑器
            'class' => 'backend\modules\editor\Module',
        ],
    ],
    'as access' => [
        'class' => 'mdm\admin\components\AccessControl',
        'allowActions' => [
            'site/*',
            // 'admin/*',
            // '*',
            // 'some-controller/some-action',
            // The actions listed here will be allowed to everyone including guests.
            // So, 'admin/*' should not appear here in the production, of course.
            // But in the earlier stages of your development, you may probably want to
            // add a lot of actions here until you finally completed setting up rbac,
            // otherwise you may not even take a first step.
        ]
    ],
    "aliases" => [    
        "@mdm/admin" => "@vendor/mdmsoft/yii2-admin",
    ],
    'components' => [
        'request' => [
            'csrfParam' => '_csrf-backend',
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => 'JV5RirLx_fsvpJLpqeA_44-lnVqJStwG',
        ],
        'user' => [
            'identityClass' => 'common\models\User',
            'enableAutoLogin' => true,
            'identityCookie' => ['name' => '_identity-backend', 'httpOnly' => true],
        ],
        'session' => [
            // this is the name of the session cookie used for login on the backend
            'name' => 'advanced-backend',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        
        'urlManager' => [
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
            ],
        ],
        
    ],
    'params' => $params,
];
