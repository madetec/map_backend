<?php

namespace backend\assets;

use yii\web\AssetBundle;

/**
 * Main backend application asset bundle.
 */
class AdminLteAsset extends AssetBundle
{
    public $sourcePath = '@vendor/almasaeed2010/adminlte/bower_components';
    public $css = [
        'Ionicons/css/ionicons.min.css',
    ];
    public $js = [
    ];
    public $depends = [
    ];
}
