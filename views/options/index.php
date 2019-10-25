<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;
use app\models\Questions;

/* @var $this yii\web\View */
/* @var $searchModel app\models\OptionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Опции';
$request = Yii::$app->request;
?>

<p><?= Html::a('Создать опцию', ['create', 'question_id' => ($question_id = $request->get('question_id')),
       'type' => ($type = $request->get('type'))], ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'image',
                'format' => 'raw',
                'filter' => false,
                'visible' => $type == Questions::TYPE_OPTIONS_IMGS,
                'value' => function ($model, $index, $widget) {
                    return Html::img(SiteHelper::resized_image($model->image, 70, null), ['width' => 70]);
                }
            ],
            'name',
            'position',
            SiteHelper::is_active($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{update}{delete}',
                'buttons' => [
                    'update' => function ($url, $model, $key) use ($question_id, $type){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update',
                            'id' => $model->id,
                            'question_id' => $question_id,
                            'type' => $type
                        ], ['title' => 'Редактировать', 'data-pjax' => 0]);
                    },
                    'delete' => function ($url, $model, $key) use ($question_id){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'question_id' => $question_id], ['title' => 'Удалить', 'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'method' => 'post'
                        ]]);
                    }
                ],
                'options' => ['width' => '50px']
            ]
        ]
    ]);
?>