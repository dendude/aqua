<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace yii\imperavi;
use yii\web\AssetBundle;


class MypluginsImperaviRedactorPluginAsset extends AssetBundle
{
    public $sourcePath = '@yii/imperavi/assets/plugins/myplugins';

    public $js = [
        'myplugins.js',
    ];

    public $css = [
        '//cdnjs.cloudflare.com/ajax/libs/font-awesome/4.0.3/css/font-awesome.min.css'
    ];
    public $depends = [
        'yii\imperavi\ImperaviRedactorAsset'
    ];

}