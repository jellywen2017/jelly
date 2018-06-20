<?php
namespace common\helper;

use Yii;
use yii\base;
class AppAlarmHelper extends AlarmHelper {

    const TYPE_ADMIN = 87;//量化

    //口袋提现告警
    private static $C_WITHDRAW_ALARM = [
        self::TYPE_ADMIN => '#env#环境：#content#',
    ];

    public static function sendAlarm($alarm_content, $type=self::TYPE_ADMIN){
        $params = [
            'content'=>mb_substr($alarm_content, 0, 1024),
            'env'=>YII_ENV,
        ];
        $content = self::$C_WITHDRAW_ALARM[$type];
        foreach ($params as $key => $value) {
            $content = preg_replace('/#'.$key.'#/',$value,$content);
        }
        if(YII_ENV!='prod'){
            return false;
        }
        self::send($type,$content);
    }
}