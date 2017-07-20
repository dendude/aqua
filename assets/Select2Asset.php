<?php

namespace app\assets;

use yii\web\AssetBundle;

class Select2Asset extends AssetBundle
{
    public $baseUrl = '/lib/select2/dist';

    public $css = [
        'css/select2.min.css',
    ];
    public $js = [
        'js/select2.min.js',
        'js/i18n/ru.js',
    ];
}