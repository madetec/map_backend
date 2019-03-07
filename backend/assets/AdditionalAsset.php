<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdditionalAsset extends AssetBundle
{
    public $sourcePath = '@bower';
    public $css = [
    ];
    public $js = [
        'inputmask/dist/min/jquery.inputmask.bundle.min.js',
    ];
    public $depends = [
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}
