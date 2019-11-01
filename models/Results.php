<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "results".
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property string $name
 * @property string $phone
 * @property string $questions
 * @property string $discount
 * @property string $referrer
 * @property int $created_at
 */
class Results extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'results';
    }
    
    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'timestamp'  => [
                'class' => TimestampBehavior::className(),
                'updatedAtAttribute' => false
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['questionnaire_id', 'name', 'phone', 'referrer'], 'required'],
            [['questionnaire_id', 'created_at'], 'integer'],
            ['questions', 'string'],
            [['name', 'referrer'], 'string', 'max' => 255],
            [['phone', 'discount'], 'string', 'max' => 20],
            ['discount', 'default', 'value' => '']
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'questionnaire_id' => 'Опрос',
            'name' => 'Имя',
            'phone' => 'Телефон',
            'questions' => 'Ответы',
            'discount' => 'Скидка',
            'referrer' => 'Источник',
            'created_at' => 'Создано'
        ];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionnaire()
    {
        return $this->hasOne(Questionnaires::className(), ['id' => 'questionnaire_id']);
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        $questions = [];
        $data = $this->questionnaire->questionsIndexed;
        $names = ArrayHelper::map($data, 'id', 'name');
        
        foreach (Json::decode($this->questions) as $key => $value) {
            switch ($data[$key]->type) {
                case Questions::TYPE_DROPDOWN: {
                    $value = $data[$key]->options[$value]['name'];
                    break;
                }
                case (Questions::TYPE_OPTIONS || Questions::TYPE_OPTIONS_AND_IMG): {
                    if (is_array($value)) {
                        $result = [];
                        
                        foreach ($value as $one) {
                            $result[] = $data[$key]->options[$one]['name'];
                        }
                        $value = implode(',', $result);
                    }
                    break;
                }
            }
            $questions[$key . ' | ' . $names[$key]] = $value;
        }
        $this->questions = $questions;
        
        parent::afterFind();
    }
}