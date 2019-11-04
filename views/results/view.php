<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Results */

\app\assets\LightGalleryAsset::register($this);

$this->title = 'Ответы клиента: ' . $model->name;

$this->registerCss(".not-set {font-size: 12px;list-style: none;color: #f05050;}");
$this->registerJs("$('.lightgallery').lightGallery();");

echo DetailView::widget([
    'model' => $model,
    'attributes' => [
        'id',
        [
            'attribute' => 'questionnaire_id',
            'value' => $model->questionnaire->title
        ],
        'name',
        'phone',
        [
            'attribute' => 'questions',
            'format' => 'raw',
            'value' => function ($model) {
                $result = '<table class="table table-striped table-bordered detail-view"><tbody>';
                foreach ($model->questions as $question => $answer) {
                    $result.= '<tr><th>' . $question . '</th><td>' . $answer . '</td></tr>';
                }
                $result.= '</tbody></table>';
                return $result;       
            }
        ],
        'discount',
        'referrer',
        'created_at:datetime'
    ]
]) ?>