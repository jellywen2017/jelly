<?php
namespace frontend\controllers;

use Yii;
use common\helpers\Res;
use Curl\Curl;
use common\services\WxService;

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

        $data = WxService::getNewToken();

        return Res::json(Res::CODE_SUCCESS, $data);
        
    }

    /**
     * @name 微信网页授权 获取code 后可以获取open_id
     * @author jellywen
     * @DateTime 2018-06-06T16:27:40+0800
     * @return   [type]                   [description]
     */
    public function actionGetCode(){

        $login_url = $_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST']."/site/login";

        $random_str = 'jellywen';

        $new_url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=".Yii::$app->params['weixin']['appid']."&redirect_uri=".$login_url."&response_type=code&scope=snsapi_userinfo&state=".$random_str."#wechat_redirect";
 
        header("Location: ".$new_url);

        //确保重定向后，后续代码不会被执行   
        exit;  
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
                    "name":"代扣",
                    "url":"http://www.baidu.com"
                },
               {
                    "type":"view",
                    "name" : "放款",
                    "url":"http://www.baidu.com"
                },{
                    "name" : "其他",
                    "sub_button":[
                        {
                            "type":"view",
                            "name":"股票",
                            "url":"http://www.baidu.com"
                        },
                        {
                            "type":"view",
                            "name":"数据",
                            "url":"http://www.baidu.com"
                        }
                    ]
                }
                
            ]}';

        $curl = new Curl();
        $curl->setTimeout(10);
        $access_token = WxService::getToken();
        $curl->post('https://api.weixin.qq.com/cgi-bin/menu/create?access_token='.$access_token,$xjson);

        if ($curl->error) {
            return Res::json($curl->errorCode, null, $curl->errorMessage);
        }

        return Res::json(Res::CODE_SUCCESS, $curl->response);

    }
}

//https://open.weixin.qq.com/connect/qrconnect?appid=wx42fceae230f2e3cf&redirect_uri=https://jellywen.cn/wx/receive-wx-call&response_type=code&scope=snsapi_base&state=3d6be0a4035d839573b04816624a415e#wechat_redirect
//
//https://open.weixin.qq.com/connect/oauth2/authorize?appid=wx42fceae230f2e3cf."&redirect_uri=https://jellywen.cn/wx/receive-wx-call&response_type=code&scope=snsapi_userinfo&state=1#wechat_redirect
