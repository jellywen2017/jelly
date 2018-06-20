<?php
/**
 * 后台操作日志
 */
namespace common\mongo;

class BaseBackendMongo extends BaseMongo{

    //默认表名
	public static $collection_name = 'default';
    public static $db_name = 'mongodb_backend';

    /**
     * 构造函数 在baseController里初始化
     * @author jellywen
     * @DateTime 2016-12-17T11:13:03+0800
     * @param    [object]                   $action yii\base\InlineAction 对象
     */
    public function __construct($action){
        if(!isset($action->controller) || !isset($action->actionMethod)){
            return false;//new出来的还是对象不为空，不过没有执行begin函数 后面都不会记mongo日志
        }
        $calss_name = get_class($action->controller);
        self::$collection_name = strtolower(trim(preg_replace('/\\\\/', '_', $calss_name)));
    }

    /**
     * 开始记录日志，可以在某个函数中间开始调用
     * @author jellywen
     * @DateTime 2016-12-17T11:06:51+0800
     * @param    string                   $action action名如：actionTestMongo
     * @param    string                   $title  本条记录标题,自动取函数注释的@name 如：测试mongo
     * @return   [type]                           [description]
     */
    public function begin($action = '', $title = '') {
        parent::begin($action, $title);
        // 可以在这里添加数据库级别的全局属性
        // $this->addLogField("BaseBackendMongo",'123456' );
    }
    
    /**
     * 日志记录结束
     * @author jellywen
     * @DateTime 2016-12-17T11:09:49+0800
     * @param    string                   $result 本机请求返回值
     * @return   [type]                           [description]
     */
    public function end($result = '') {
        parent::end($result);
    }
    
    /**
     * 给记录增加属性
     * @author jellywen
     * @DateTime 2016-12-16T14:52:12+0800
     * @param    [string]                   $field_name 属性名属性值
     * @param    [string|array]             $value      属性具体内容
     */
    public function addLogField($field_name, $value){
        parent::addLogField($field_name, $value);
    }

    /**
     * 添加日志
     * @param string $title     日志标题
     * @param array $content    日志内容
     */
    public function addLogDetail($title, $log_data='') {
        $data = [];
        //增加调试信息
        $trc = debug_backtrace(1);
        if( isset($trc[0]) && isset($trc[0]['file']) && isset($trc[0]['line'])){
            $data['title'] = "[{$title}] [".date('Y-m-d H:i:s')."] [{$trc[0]['file']}] [{$trc[0]['line']}]";
        }        
        if(is_array($log_data)){
            $data = array_merge($data,$log_data);
        }else if($log_data!==''){
            $data[] = $log_data;
        }
        parent::addLogDetail($title, $data);
    }

}
