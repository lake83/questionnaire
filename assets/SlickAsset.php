<?php

namespace app\assets;

use yii\web\AssetBundle;

class SlickAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/slick.css',
        'css/slick-theme.css'
    ];
    public $js = [
        'js/slick.min.js'
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}