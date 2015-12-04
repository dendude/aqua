<?php
namespace yii\ckeditor;

use yii\web\AssetBundle;

class CKEditorAsset extends AssetBundle
{
    public $sourcePath = '@bower/ckeditor';
    public $css = [
        //'skins/lightgray/content.inline.min.css',
    ];
    public $js = [
        'ckeditor.js',
        //'skins/kama/skin.js',
        'lang/ru.js',
    ];
    public $depends = [
        'app\assets\AdminAsset',
    ];
}