<?php

namespace app\controllers;

use Yii;
use app\models\Results;
use app\models\Questions;
use yii\web\NotFoundHttpException;
use yii\base\DynamicModel;
use yii\helpers\Json;
use yii\web\UploadedFile;
use yii\helpers\Inflector;

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
        $arr = ['name', 'phone', 'referrer'];
        
        if ($model->is_discount) {
            $arr = array_merge($arr, ['discount']);
        }
        $data = new DynamicModel(array_merge($fields, $arr));
        $data->addRule(array_merge($fields_required, $arr), 'required')
             ->addRule('name', 'match', ['pattern' => '/^(([a-z\(\)\s]+)|([а-яё\(\)\s]+))$/isu'])
             ->addRule('phone', 'match', ['pattern' => '/^((8|\+7)[\- ]?)?(\(?\d{3}\)?[\- ]?)?[\d\- ]{7,10}$/']);
        
        if ($fields_safe) {
            $data->addRule($fields_safe, 'safe');
        }      
        
        if ($data->load($request->post())) {
            $fields = [];
            $questions = $model->questionsIndexed;
            $result = new Results(['questionnaire_id' => $id]);
            $result->name = $data->name;
            $result->phone = $data->phone;
            
            if ($model->is_discount) {
                $result->discount = $data->discount;
            }
            $result->referrer = $data->referrer;
            
            foreach ($data->attributes as $key => $field) {
                if (strpos($key, 'field_') !== false) {
                    $key_id = str_replace('field_', '', $key);
                    
                    if ($questions[$key_id]->type == Questions::TYPE_FILE && !empty($field)) {
                        $images = [];
                        
                        foreach (UploadedFile::getInstances($data, $key) as $image) {
                            $title = Inflector::slug($image->baseName) . '_' . $key_id . '_' . time() . '.' . $image->extension;
                            $image->saveAs(Yii::$app->basePath . '/web/images/uploads/source/answers/' . $title);
                            $images[] = 'answers/' . $title;
                        }
                        $fields[$key_id] = $images;
                    } else {
                        $fields[$key_id] = $field;
                    }
                }
            }
            $result->questions = Json::encode($fields);
            
            if ($result->save() && $result->sendEmail()) {
                Yii::$app->response->data = $this->renderPartial('thanks');
            }
            Yii::$app->end();
        }
        return $this->renderAjax('view', ['model' => $model, 'questions' => $questions, 'data' => $data]);
    }
}