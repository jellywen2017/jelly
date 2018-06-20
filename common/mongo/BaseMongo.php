<?php
/**
 * mongo日志基类
 */
namespace common\mongo;

use Yii;
use yii\base\UserException;
use common\models\ActionModel;
use common\helper\AlarmHelper;

class BaseMongo extends \yii\mongodb\ActiveRecord {
    
    /** @var  static $mLog */
    public static $mLog;//具体mongo实例

    private static $_document = ['title'=>'', 'begin_time'=>0, 'end_time'=>0, 'err_code'=>0, 'err_msg'=>''];//整条记录 
    public static $details = [];//过程详情
    private static $result = [];//返回结果

    private static $_log_begin = false;//能否记录日志

    /**
     * 异常日志
     * @param Exception $exception
     */
    public static function addExceptionLog($exception) {
        
        if(!self::canLog()) return false;
        
        $code = $exception->getCode();
        $message = $exception->getMessage();
        
        $log_data = [];
        $log_data['err_code'] = $code;
        $log_data['err_msg']  = $message;
        $log_data['file']     = $exception->getFile();
        $log_data['line']     = $exception->getLine();

        //告警错误详情
        $log_data['type'] = get_class($exception);
        if (!$exception instanceof UserException) {
            $log_data['file'] = $exception->getFile();
            $log_data['line'] = $exception->getLine();
            $log_data['stack-trace'] = explode("\n", $exception->getTraceAsString());
            if ($exception instanceof \yii\db\Exception) {
                $log_data['error-info'] = $exception->errorInfo;
            }
        }
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $log_data['client_ip'] = $_SERVER['HTTP_X_FORWARDED_FOR'];//服务器ip
        }
        DebitAlarmHelper::sendAlarm("支付异常".var_export($log_data,true));
        if(!empty(self::$mLog)){
            self::$_document['err_code'] = $code;
            self::$_document['err_msg'] = $message;
            self::$mLog->addLogDetail(self::$_document['title'] . '异常', $log_data);
            self::$_document['err_code'] = $code;
            self::$_document['err_msg']  = $message;
            self::$mLog->end();
        }
    }

    public static function closeLog(){
        self::$_log_begin = false;
    }

    public static function openLog(){
        self::clearData();
        self::$_log_begin = true;
    }

    public static function canLog(){
        return self::$_log_begin;
    }

    /**
     * 设置库名
     */
    public static function setDbName($db_name)
    {
        static::$db_name = $db_name;
    }

    /**
     * 设置集合名
     */
    public static function setCollectionName($collection_name)
    {
        static::$collection_name = $collection_name;
    }

    /**
     * 开始记录日志，可以在某个函数中间开始调用
     * @author jellywen
     * @DateTime 2016-12-17T11:06:51+0800
     * @param    string                   $action_name action名如：actionTestMongo
     * @param    string                   $title  本条记录标题,自动取函数注释的@name 如：测试mongo
     * @return   [type]                           [description]
     */
    public function begin($action_name = '', $title = '') {
        self::openLog();
        $this->addLogField('begin_time', date('Y-m-d H:i:s'));
        $this->addLogField('action', $action_name);
        $this->addLogField('title', $title);//日志标题
        if(isset($_REQUEST) && self::$mLog){
            self::$mLog->addLogDetail(self::$_document['title'] . '-开始-请求参数', $_REQUEST);
        }
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
            $this->addLogField('client_ip', $_SERVER['HTTP_X_FORWARDED_FOR']);//服务器ip
        }
        if(isset($_SERVER['SERVER_ADDR'])){
            $this->addLogField('server_ip', $_SERVER['SERVER_ADDR']);//服务器ip
        }
        // if(isset(Yii::$app->request) && isset(Yii::$app->request->userIP)){
        //     BaseMongo::$mLog->addLogField('client_ip', Yii::$app->request->userIP);
        // }        
        register_shutdown_function(function() {
            $this->end();
        });
    }

    /**
     * 必须方法 返回表名
     * @author jellywen
     * @DateTime 2016-12-17T11:05:51+0800
     * @return   [type]                   [description]
     */
	public static function collectionName(){
		return static::$collection_name;
	}
    
    /**
     * 必须方法 返回数据库名
     * @author jellywen
     * @DateTime 2016-12-17T11:06:27+0800
     * @return   [type]                   [description]
     */
    public static function getDb() {
        return \Yii::$app->get(static::$db_name);
    }
    
    /**
     * [init description]
     * @author jellywen
     * @DateTime 2016-12-30T14:52:30+0800
     * @param    [object]                   $action yii\base\InlineAction 对象
     * @return   [type]                           [description]
     */
    public function initMongo($action){
        if(!isset($action) || !isset($action->controller) || !isset($action->actionMethod)){
            return false;
        }
        // 定义mongo日志记录地点
        // 规则: $controller->mongoName = ['action' => ['集合', '库(可不填)']]
        // 如果规则不存在，则使用默认库名，集合
        $controller = & $action->controller;
        if(isset($controller->mongoName) && isset($controller->mongoName[$action->actionMethod])) {
            static::$collection_name = $controller->mongoName[$action->actionMethod][0];
            if(isset($controller->mongoName[$action->actionMethod][1])) {
                static::$db_name = $controller->mongoName[$action->actionMethod][1];
            }
        }
        $class_name = get_class($controller);
        $title = $this->getMethodName($class_name, $action->actionMethod);
        $this->begin($action->actionMethod, $title);
    }
    
    /**
     * 日志记录结束
     * @author jellywen
     * @DateTime 2016-12-17T11:09:49+0800
     * @param    string                   $result 本机请求返回值
     * @return   [type]                           [description]
     */
    public function end($result = '') {
        // if(!self::canLog() || (empty(self::$_document) && empty(self::$details)) ) {
        if(!self::canLog() || count(self::$details)<=1 || empty(self::$mLog) ) {//无日志的不计, 只有请求参数的 不记录
            return false;
        }
        $this->addLogField('end_time', date('Y-m-d H:i:s'));
        if(!empty($result)){
            self::$result = $result;
        }
        //组装数据
        self::$mLog->addLogDetail(self::$_document['title'] . '-结束-返回数据', self::$result);
        self::$_document['details'] = self::$details;

        try {
            $collection = self::getCollection();
            //print_r(self::$_document);
            // $rs = $collection->insert(self::$_document);
            \Yii::info(self::$_document,"info");
		}
        catch (\Exception $e) {//Mongodb 异常
            // print_r(self::$_document);
            // print_r($e->getMessage()); print_r($e->getCode());
            \Yii::error(var_export(self::$_document, true));
            DebitAlarmHelper::sendAlarm("js_pay写mongo出错:".$e->getMessage());
        }
        //防止两次写入
        self::closeLog();
        self::clearData();
    }

    /**
     * 给记录增加属性
     * @author jellywen
     * @DateTime 2016-12-16T14:52:12+0800
     * @param    [string]                   $field_name 属性名属性值
     * @param    [string|array]             $value      属性具体内容
     */
    public function addLogField($field_name, $value){
        if(!self::canLog()){
            return false;
        }
        self::$_document[$field_name] = $value;
    }
    
    /**
     * 添加日志
     * @param string $title     日志标题
     * @param array $content    日志内容
     */
    public function addLogDetail($title, $log_data='') {
        
        if(!self::canLog() || empty($title)){
            return false;
        }
        
        self::_is_error($log_data);
        
        $log_detail = [];
        // $log_detail['title'] = $title;
        if(is_array($log_data)) {
            $log_detail = array_merge($log_detail, $log_data);
        }else {
            $log_detail[] = $log_data;
        }
        // $log_detail['time'] = date('Y-m-d H:i:s');
        array_push(self::$details, $log_detail);
    }
    
    /**
     * 获取方法里注释的name
     * @author jellywen
     * @DateTime 2016-12-16T11:52:34+0800
     * @param string $class_name     类全名
     * @param string $action_name    方法名
     * @return   [type]                   [description]
     */
    public function getMethodName($class_name, $action_name){
        $rf = new \ReflectionClass($class_name);
        $methods = $rf->getMethods(\ReflectionMethod::IS_PUBLIC);
        foreach ($methods as $method) {
            if (strpos($method->name, 'action') === false || $method->name == 'actions') {
                continue;
            }
            $actionModel = new ActionModel($method);
            if($action_name == $method->name){
                return $actionModel->getTitle();
            }
        }
        return "";
    }

    private static function clearData(){
        self::$_document = ['title'=>'', 'begin_time'=>0, 'end_time'=>0, 'err_code'=>0, 'err_msg'=>''];
        self::$details = [];
        self::$result = [];
    }

    /**
     * 日志是否出错
     * @param array $log_data
     */
    private static function _is_error($log_data) {
        
        if(is_string($log_data)) {
            return false;
        }
        
        if(!empty($log_data) && (isset($log_data['err_code']) || isset($log_data['err_msg']))) {
            self::$_document['err_code'] = $log_data['err_code'];  //日志错误码
            self::$_document['err_msg'] = $log_data['err_msg'];   //日志错误说明
        }
    }

}
