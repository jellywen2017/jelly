<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\web;

/**
 * This asset bundle provides the base JavaScript files for the Yii Framework.
 *
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class YiiAsset extends AssetBundle
{
    public $sourcePath = '@yii/assets';
    public $js = [
        'yii.js',
    ];
    public $depends = [
        'yii\web\JqueryAsset',
    ];
        //将默认js 放至开头
    public $jsOptions = [
        'position' => View::POS_HEAD,
    ];
}
