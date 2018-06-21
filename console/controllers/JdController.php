<?php
namespace console\controllers;

use Yii;
use common\helpers\AppAlarmHelper;
use Curl\Curl;

class JdController extends BaseMongoController {

    public function actionDegree(){
        $params = [
            'source'=>'smartH5',
            ];
        $curl = new Curl();
        $curl->post('https://ms.jr.jd.com/gw/generic/pc_jj/h5/m/getDegreeInfo',$params);
        if ($curl->error) {
            Yii::error("code:".$curl->errorCode." message:".$curl->errorMessage);
            return false;
        }
        $data = $curl->response;

        $degree = $data->resultData->datas->degree;
        $degreeDate = $data->resultData->datas->degreeDate;

        $msg = "热度:".$degree." 日期:".$degreeDate;
        echo $msg;
        AppAlarmHelper::sendAlarm($msg);
    }

}
