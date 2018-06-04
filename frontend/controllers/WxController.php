<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;

/**
 * Site controller
 */
class WxController extends Controller
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
        
    }

    public function actionGetToken(){
        
    }
}
