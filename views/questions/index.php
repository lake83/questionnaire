<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionsSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Вопросы';
?>

<p><?= Html::a('Создать вопрос', ['create', 'questionnaire_id' => ($questionnaire_id = Yii::$app->request->get('questionnaire_id'))], ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            'name',
            [
                'attribute' => 'type',
                'filter' => Html::activeDropDownList($searchModel, 'type', $searchModel->getTypes(),
                    ['class' => 'form-control', 'prompt' => '- выбрать -']
                ),
                'value' => function ($model, $index, $widget) {
                    return $model->getTypes($model->type);
                }
            ],
            'position',
            'is_required:boolean',
            'is_several:boolean',
            SiteHelper::is_active($searchModel),
            SiteHelper::created_at($searchModel),            

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{options} {update} {delete}',
                'buttons' => [
                    'options' => function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-list"></span>', ['options/index', 'question_id' => $model->id, 'type' => $model->type], ['title' => 'Опции', 'data-pjax' => 0]);
                    },
                    'update' => function ($url, $model, $key) use ($questionnaire_id){
                        return Html::a('<span class="glyphicon glyphicon-pencil"></span>', ['update', 'id' => $model->id, 'questionnaire_id' => $questionnaire_id], ['title' => 'Редактировать', 'data-pjax' => 0]);
                    },
                    'delete' => function ($url, $model, $key) use ($questionnaire_id){
                        return Html::a('<span class="glyphicon glyphicon-trash"></span>', ['delete', 'id' => $model->id, 'questionnaire_id' => $questionnaire_id], ['title' => 'Удалить', 'data' => [
                            'confirm' => 'Вы уверены, что хотите удалить этот элемент?',
                            'method' => 'post'
                        ]]);
                    }
                ],
                'visibleButtons' => [
                    'options' => function ($model, $key, $index){
                        return $model->type == $model::TYPE_OPTIONS || $model->type == $model::TYPE_OPTIONS_IMGS ||
                            $model->type == $model::TYPE_OPTIONS_AND_IMG || $model->type == $model::TYPE_DROPDOWN;
                    }
                ],
                'options' => ['width' => '70px']
            ]
        ]
    ]);
?>