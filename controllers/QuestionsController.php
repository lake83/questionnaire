<?php

namespace app\controllers;

/**
 * QuestionsController implements the CRUD actions for Questions model.
 */
class QuestionsController extends AdminController
{
    public $modelClass = 'app\models\Questions';
    public $searchModelClass = 'app\models\QuestionsSearch';
    
    public function actions()
    {
        $actions = parent::actions();
        
        $actions['create']['redirect'] = $actions['update']['redirect'] = $actions['delete']['redirect'] =
        ['index', 'questionnaire_id' => \Yii::$app->request->get('questionnaire_id')];
        
        return $actions;
    }
}