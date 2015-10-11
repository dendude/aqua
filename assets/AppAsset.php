<?php
/**
 * @link http://www.yiiframework.com/
 * @copyright Copyright (c) 2008 Yii Software LLC
 * @license http://www.yiiframework.com/license/
 */

namespace app\assets;

use yii\web\AssetBundle;

/**
 * @author Qiang Xue <qiang.xue@gmail.com>
 * @since 2.0
 */
class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/main.css',
        'css/site.css',
        'css/modal.css',
        'css/sm_slider.css',
        'css/colorbox.css',
    ];
    public $js = [
        'js/main.js',
        'js/share42/share42.js',
        'js/jquery.smslider.js',
        'js/jquery.colorbox.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\glyphicons\GlyphiconsAsset',
    ];
}
