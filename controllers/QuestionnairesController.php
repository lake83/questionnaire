<?php

namespace app\controllers;

use Yii;
use app\models\Results;
use yii\web\NotFoundHttpException;
use yii\base\DynamicModel;
use yii\helpers\Json;

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
        $fields = [];
        $request = Yii::$app->request;
        
        if ($data = $request->post('DynamicModel')) {
            $result = new Results(['questionnaire_id' => $id]);
            $result->name = $data['name'];
            $result->phone = $data['phone'];
            
            if ($model->is_discount) {
                $result->discount = $data['discount'];
            }
            $result->referrer = $request->referrer;
            
            foreach ($data as $key => $field) {
                if (strpos($key, 'field_') !== false) {
                    $fields[str_replace('field_', '', $key)] = $field;
                }
            }
            $result->questions = Json::encode($fields);
            
            if ($result->save()) {
                Yii::$app->response->data = $this->renderPartial('thanks');
            }
            Yii::$app->end();
        }
        $fields_required = [];
        $fields_safe = [];
        
        foreach (($questions = $model->questions) as $question) {
            $fields[] = 'field_' . $question['id'];
            if ($question['is_required']) {
                $fields_required[] = 'field_' . $question['id'];
            } else {
                $fields_safe[] = 'field_' . $question['id'];
            }
        }
        $arr = ['name', 'phone'];
        
        if ($model->is_discount) {
            $arr = array_merge($arr, ['discount']);
        }
        $data = new DynamicModel(array_merge($fields, $arr));
        $data->addRule(array_merge($fields_required, $arr), 'required');
        
        if ($fields_safe) {
            $data->addRule($fields_safe, 'safe');
        }
        return $this->renderAjax('view', ['model' => $model, 'questions' => $questions, 'data' => $data]);
    }
}