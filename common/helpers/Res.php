<?php
namespace common\helpers;

use Yii;

class Res
{

	//公用
 	const CODE_SUCCESS = 0;
    const CODE_INPUT_INVALID = 100001;
    const CODE_FORMAT_ERROR = 100002;
    const CODE_SIGN_ERROR = 100003;
    const CODE_REQUEST_TOO_FREQUENTLY = 100004;
    const CODE_COM_SYSTEM_ERROR        = 100005;
    const CODE_COM_SYSTEM_MAINTAIN     = 100006;
    const CODE_LOCK_FAIL               = 100007;
    const CODE_UNLOCK_FAIL             = 100008;


    static $err_map = [
    	//公用
        self::CODE_SUCCESS => '成功',
        self::CODE_INPUT_INVALID => '输入错误',
        self::CODE_SIGN_ERROR => '验签失败',
        self::CODE_REQUEST_TOO_FREQUENTLY => '请求过于频繁',
        self::CODE_COM_SYSTEM_ERROR          => '系统错误',
        self::CODE_COM_SYSTEM_MAINTAIN       => '系统维护，请稍候在试',
        self::CODE_LOCK_FAIL                 => '加锁失败',
        self::CODE_UNLOCK_FAIL               => '解锁失败',

    ];

    public static function json($code, $data=[], $msg='')
    {
    	if(empty($msg)){
    		$msg = isset(static::$err_map[$code])?static::$err_map[$code]:'未知错误信息';
    	}
        return ['code'=>$code, 'msg'=>$msg,'data'=>$data ];

    }

}