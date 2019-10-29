<?php

namespace app\controllers;

/**
 * ResultsController implements the CRUD actions for Results model.
 */
class ResultsController extends AdminController
{
    public $modelClass = 'app\models\Results';
    public $searchModelClass = 'app\models\ResultsSearch';
    
    /**
     * Displays a result
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (!$model = $this->modelClass::findOne($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->render('view', ['model' => $model]);
    }
}