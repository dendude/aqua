<?php
namespace app\assets;

use yii\web\AssetBundle;

class AppAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    
    public $css = [
        'css/main.css?3',
        'css/site.css?3',
        'css/modal.css?3',
        'css/sm_slider.css?3',
        'css/adaptive.css?3',
        
        '/lib/font-awesome/css/font-awesome.min.css',
        '/lib/colorbox/example3/colorbox.css',
    ];
    public $js = [
        'js/main.js?3',
        'js/share42/share42.js',
        'js/jquery.smslider.js',

        '/lib/colorbox/jquery.colorbox.js',
        '/lib/colorbox/i18n/jquery.colorbox-ru.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\glyphicons\GlyphiconsAsset',
    ];
}
