<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

class BaseController extends Controller
{

    // 由于都是api接口方式，所以不启用csrf验证
    public $enableCsrfValidation = false;

    public function init(){
        Yii::$app->response->format = Response::FORMAT_JSON;
        parent::init();
    }

}

