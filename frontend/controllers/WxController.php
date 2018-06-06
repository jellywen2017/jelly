<?php
namespace frontend\controllers;

use Yii;
use common\helpers\Res;
use Curl\Curl;

/**
 * Site controller
 */
class WxController extends BaseController
{
    public function actionWxCheckSignature()
    {
        $signature = Yii::$app->request->get('signature');
        $timestamp = Yii::$app->request->get('timestamp');
        $nonce = Yii::$app->request->get('nonce');
        $echostr = Yii::$app->request->get('echostr');
        $token = "jellywen";

        $tmpArr = [$timestamp, $nonce,$token];
        sort($tmpArr, SORT_STRING);
        $tmpStr = implode( $tmpArr );
        $tmpStr = sha1( $tmpStr );

        if( $signature == $tmpStr){
            return $echostr;
        }else{
            return false;
        }
    }

    public function actionReceiveWxCall(){
        return "ok";
    }

    /**
     * @name 获取 刷新token
     * @method GET
     * @author jellywen
     * @DateTime 2018-06-06T14:51:45+0800
     * @return   [type]                   [description]
     */
    public function actionGetToken(){
        $params = [
            'grant_type'=>'client_credential',
            'appid'=>'wx42fceae230f2e3cf',
            'secret'=>'49aebd63400e98945fb096ce3e133920',
            ];
        $curl = new Curl();
        $curl->setTimeout(10);
        $curl->get('https://api.weixin.qq.com/cgi-bin/token',$params);
        if ($curl->error) {
            return Res::json($curl->errorCode, null, $curl->errorMessage);
        }
        $data = $curl->response;
        // Yii::$app->redis->set('access_token',$data['access_token']);
        // Yii::$app->redis->expire()
        return Res::json(Res::CODE_SUCCESS, $data);
        
    }


    /**
     * @name 更新菜单
     * @method GET
     * @author jellywen
     * @DateTime 2018-06-06T14:51:17+0800
     * @return   [type]                   [description]
     */
    public function actionMenu(){

        $xjson = '{
            "button":[
                {
                   "type":"view",
                    "name":"首页",
                    "url":"http://www.baidu.com"
                },
               {
                    "type":"view",
                    "name" : "A股点买",
                    "url":"http://www.baidu.com"
                },{
                    "name" : "我的账户",
                    "sub_button":[
                        {
                            "type":"view",
                            "name":"个人中心",
                            "url":"http://www.baidu.com"
                        },
                        {
                            "type":"view",
                            "name":"帮助中心",
                            "url":"http://www.baidu.com"
                        }
                    ]
                }
                
            ]}';
        $curl = new Curl();
        $curl->setTimeout(10);
        $curl->post('https://api.weixin.qq.com/cgi-bin/menu/create?access_token=10_xdHaGcfGdcrlvDm_RTl5xH4nDz6UcdDNlWJq0mEkQuk6CbBjGu9gtS1xWtkBD839G_DnpO5-9UFxAzVTQgEUTdxR0A6nkv1Ov7HJS65s9kKkMrVBvHiijd2DSuQUNKjAJAEXU',$xjson);
        if ($curl->error) {
            return Res::json($curl->errorCode, null, $curl->errorMessage);
        }
        return Res::json(Res::CODE_SUCCESS, $curl->response);

    }
}

//https://open.weixin.qq.com/connect/qrconnect?appid=wx42fceae230f2e3cf&redirect_uri=https://jellywen.cn/wx/receive-wx-call&response_type=code&scope=snsapi_login&state=STATE

