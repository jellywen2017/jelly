<?php
namespace common\services;

use Yii;
use Curl\Curl;

class WxService
{

    /**
     * @name 强制获取新token
     * @author jellywen
     * @DateTime 2018-06-06T15:23:32+0800
     * @return   [type]                   [description]
     */
    public static function getNewToken(){
        $params = [
            'grant_type'=>'client_credential',
            'appid'=>Yii::$app->params['weixin']['appid'],
            'secret'=>Yii::$app->params['weixin']['secret'],
            ];
        $curl = new Curl();
        // $curl->setTimeout(10);
        $curl->get('https://api.weixin.qq.com/cgi-bin/token',$params);
        if ($curl->error) {
            Yii::error("code:".$curl->errorCode." message:".$curl->errorMessage);
            return false;
        }

        $data = $curl->response;
        Yii::$app->redis->set('access_token',$data->access_token);
        Yii::$app->redis->expire('access_token',$data->expires_in);
        Yii::info("access_token:".Yii::$app->redis->get('access_token'));
        return $data;
    }

    /**
     * @name 获取token
     * @author jellywen
     * @DateTime 2018-06-06T15:23:17+0800
     * @return   [type]                   [description]
     */
    public static function getToken()
    {
        $token = Yii::$app->redis->get('access_token');
        if(empty($token)){
            $data = self::getNewToken();
            if(empty($data)){
                Yii::error("强制获取token失败");
                return false;
            }else{
                $token = $data->access_token;
            }
        }
        return $token;
    }

    /**
     * @name
     * @author jellywen
     * @DateTime 2018-06-06T17:01:50+0800
     * @param    [type]                   $code 通过 https://open.weixin.qq.com/connect/oauth2/authorize 获取
     * @return   [type]                         [description]
     */
    public static function getCodeToken($code){
        $params = [
            'grant_type'=>'authorization_code',
            'appid'=>Yii::$app->params['weixin']['appid'],
            'secret'=>Yii::$app->params['weixin']['secret'],
            'code'=>$code,
            ];
        $curl = new Curl();
        $curl->get('https://api.weixin.qq.com/sns/oauth2/access_token',$params);
        if ($curl->error) {
            Yii::error("code:".$curl->errorCode." message:".$curl->errorMessage);
            return false;
        }
        $data = json_decode($curl->response,true);
        if(isset($data['errcode'])){
            Yii::error("获取access_token失败:".var_export($data,true));
            return false;
        }
        // echo var_dump($curl->response);die;
        Yii::info("access_token:".$data['access_token']);
        Yii::info("expires_in:".$data['expires_in']);
        Yii::info("openid:".$data['openid']);
        Yii::info("scope:".$data['scope']);
        return $data;
    }

}