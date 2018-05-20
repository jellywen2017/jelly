<?php
//重要配置加入忽略文件
$important=[];
$important['db']=[
            'class' => 'yii\db\Connection',
            'dsn' => 'mysql:host=172.31.231.210;dbname=jelly',
            'username' => '数据库账号',
            'password' => '数据库密码',
            'charset' => 'utf8',
        ];
$important['mailer']=[
            'class' => 'yii\swiftmailer\Mailer',
            'viewPath' => '@common/mail',
            //false：非测试状态，发送真实邮件而非存储为文件
            'useFileTransport' => false,

            'transport' => [
                'class' => 'Swift_SmtpTransport',
                'host' => 'smtp.exmail.qq.com',
                'username' => 'jelly@jellywen.cn',
                'password' => '发件密码',
                'port' => '465',
                'encryption' => 'ssl',
            ],
            'messageConfig'=>[ //指定默认发件人
                'charset'=>'UTF-8',
                'from'=>['jelly@jellywen.cn'=>'jelly']
            ],
        ];
return $important;

