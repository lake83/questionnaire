<?php

use yii\helpers\Html;
use kartik\grid\GridView;
use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $searchModel app\models\QuestionnairesSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Опросы';

$this->registerJsFile('/js/questionnaires.js', ['depends' => 'yii\web\JqueryAsset']);
?>

<p><?= Html::a('Создать опрос', ['create'], ['class' => 'btn btn-success']) ?></p>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            'title',
            SiteHelper::created_at($searchModel),

            [
                'class' => 'yii\grid\ActionColumn',
                'template' => '{questions} {view} {update} {delete}',
                'buttons' => [
                    'view' => function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-eye-open"></span>', ['view', 'id' => $model->id], [
                            'title' => 'Просмотр',
                            'data-questionnaire' => $model->id,
                            'data-pjax' => 0
                        ]);
                    },
                    'questions' => function ($url, $model, $key){
                        return Html::a('<span class="glyphicon glyphicon-question-sign"></span>', ['questions/index', 'questionnaire_id' => $model->id], [
                            'title' => 'Вопросы',
                            'data-pjax' => 0
                        ]);
                    }
                ],
                'options' => ['width' => '100px']
            ]
        ]
    ]);

?>