<?php

namespace app\controllers;

use yii\web\NotFoundHttpException;

/**
 * QuestionnairesController implements the CRUD actions for Questionnaires model.
 */
class QuestionnairesController extends AdminController
{
    public $modelClass = 'app\models\Questionnaires';
    public $searchModelClass = 'app\models\QuestionnairesSearch';
    
    /**
     * Displays a questionnaire
     * @param integer $id
     * @return mixed
     */
    public function actionView($id)
    {
        if (!$model = $this->modelClass::findOne($id)) {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
        return $this->renderAjax('view', ['model' => $model]);
    }
}