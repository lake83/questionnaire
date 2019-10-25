<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

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
            [['phone', 'discount'], 'string', 'max' => 20]
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
}