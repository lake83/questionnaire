<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\ResultsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Результаты';

echo GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],
            
            [
                'attribute' => 'questionnaire_id',
                'value' => function ($model, $index, $widget) {
                    return $model->questionnaire->title;
                }
            ],
            'name',
            'phone',
            SiteHelper::created_at($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{view} {delete}',
                'options' => ['width' => '50px']
            ]
        ]
    ]);
?>