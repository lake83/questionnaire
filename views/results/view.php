<?php

use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\Results */

$this->title = 'Ответы клиента: ' . $model->name;

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
            'value' => DetailView::widget(['model' => $model->questions])
        ],
        'discount',
        'referrer',
        'created_at:datetime'
    ]
]) ?>