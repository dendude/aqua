<?php
namespace yii\tinymce;

use yii\web\AssetBundle;

class TinyMceAsset extends AssetBundle
{
    public $sourcePath = '@vendor/tinymce/tinymce';
    public $css = [
        'skins/lightgray/content.inline.min.css',
    ];
    public $js = [
        'tinymce.min.js',
        'themes/modern/theme.min.js',
    ];
    public $depends = [
        'app\assets\AdminAsset',
    ];
}