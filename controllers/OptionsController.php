<?php

namespace app\controllers;

/**
 * OptionsController implements the CRUD actions for Options model.
 */
class OptionsController extends AdminController
{
    public $modelClass = 'app\models\Options';
    public $searchModelClass = 'app\models\OptionsSearch';
    
    public function actions()
    {
        $actions = parent::actions();
        $request = \Yii::$app->request;
        
        $actions['create']['redirect'] = $actions['update']['redirect'] = $actions['delete']['redirect'] =
        ['index', 'question_id' => $request->get('question_id'), 'type' => $request->get('type')];
        
        return $actions;
    }
}