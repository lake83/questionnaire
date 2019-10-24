<?php

namespace app\assets;

use yii\web\AssetBundle;

class QuestionnaireAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [
        'css/questions.css'
    ];
    public $js = [];
    public $depends = [
        'yii\bootstrap\BootstrapAsset'
    ];
}