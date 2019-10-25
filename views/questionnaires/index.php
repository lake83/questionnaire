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

<p>
    <?= Html::a('Создать опрос', ['create'], ['class' => 'btn btn-success']) ?>
    <?= Html::a('<i class="fa fa-info-circle"></i>', ['#'], ['id' => 'blocks-info-btn', 'class' => 'btn btn-info pull-right']) ?>
</p>
<div id="blocks-info" class="hidden">
   <h2>Установка</h2>
   <div>
   <textarea readonly="readonly" rows="16" class="form-control" style="resize:none">
Для работы виджета необходимо подключение jQuery.
После файла jQuery подключается рабочий JS файл.
       
Например:
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="<?= \yii\helpers\Url::base(true); ?>/js/questionnaires.js" type="application/javascript"></script>
       
Ссылка для открытия виджета должна содержать элемент data-questionnaire="<id>"
       
Например:
<a href="#" data-questionnaire="1">Опрос</a>
       
где <id> - ID опроса в системе.
   </textarea>
       
   </div>
</div>

<?=  GridView::widget([
    'layout' => '{items}{pager}',
    'dataProvider' => $dataProvider,
    'pjax' => true,
    'export' => false,
    'filterModel' => $searchModel,
        'columns' => [
        ['class' => 'yii\grid\SerialColumn'],

            [
                'attribute' => 'id',
                'options' => ['width' => '100px']
            ],
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