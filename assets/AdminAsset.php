<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/dashboard.css',
        'css/admin.css',
    ];
    public $js = [
        'js/main.js',
        'js/date.js',
        'js/admin.js',
        'js/jquery.filedrop.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\glyphicons\GlyphiconsAsset',
        'app\assets\Select2Asset'
    ];
}