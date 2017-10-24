<?php

namespace app\assets;

use yii\web\AssetBundle;

class AdminAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';

    public $css = [
        'css/dashboard.css?3',
        'css/admin.css?3',
    ];
    public $js = [
        'js/main.js?3',
        'js/date.js?3',
        'js/admin.js?3',
        'js/jquery.filedrop.js',
    ];

    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\glyphicons\GlyphiconsAsset',
        'app\assets\Select2Asset'
    ];
}