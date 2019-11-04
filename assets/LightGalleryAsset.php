<?php

namespace app\assets;

use yii\web\AssetBundle;

class LightGalleryAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'https://use.fontawesome.com/releases/v5.0.1/css/all.css',
        'css/lightgallery.min.css'
    ];
    public $js = [
        'js/lightgallery-all.min.js'      
    ];
    public $depends = [
        'yii\web\JqueryAsset'
    ];
}