<?php
namespace console\controllers;

use Yii;
// use common\mongo\BaseMongo;
// use common\mongo\BaseConsoleMongo;

abstract class BaseMongoController extends \yii\console\Controller
{
	// 由于都是api接口方式，所以不启用csrf验证
	public $enableCsrfValidation = false;

	public function init()
	{
		parent::init();
	}

	public function beforeAction($action)
	{
        // BaseMongo::$mLog = new BaseConsoleMongo($action);
        // if(!empty(BaseMongo::$mLog)){
        // 	BaseMongo::$mLog->initMongo($action);
        // }        
        //日志记录开始
        $ret = parent::beforeAction($action);
        //这里可以记录BaseController 级别的公用属性 
        return $ret;
	}

	public function afterAction($action, $result)
	{
		$result = parent::afterAction($action, $result);

		//日志记录结束
		// if(!empty(BaseMongo::$mLog)){
  //           BaseMongo::$mLog->end($result);
  //       }
		return $result;
	}

	/**
     * 输出错误信息到控制台，并记录log
     * @param string $message
     * @param bool $log 是否记录日志，默认是
     */
    public function error($message, $log = false) {
        echo date('Y-m-d H:i:s ')."error: {$message}\n";
    }

    /**
     * 输出信息到控制台，并记录log
     * @param string $message
     * @param bool $log 是否记录日志，默认否
     */
    public function message($message, $log = false) {
        echo date('Y-m-d H:i:s ')."info: {$message}\n";
    }
}