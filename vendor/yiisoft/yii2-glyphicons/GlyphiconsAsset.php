<?php
/**
 * glyphicons
 */

namespace yii\glyphicons;

use yii\web\AssetBundle;

/**
 * Asset bundle for the Glyphicons css files.
 *
 * @author DenDude <denis.kravtsov.1986@mail.ru>
 * @since 1.0
 */
class GlyphiconsAsset extends AssetBundle
{
    public $sourcePath = '@vendor/glyphicons';
    public $css = [
        'css/glyphicons.css',
    ];
}