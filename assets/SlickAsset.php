<?php

namespace app\assets;

use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/slick.min.css',
        'css/slick-theme.min.css'
    ];
    public $js = [
        'js/slick.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}