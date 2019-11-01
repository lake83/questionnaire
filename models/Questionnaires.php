<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "questionnaires".
 *
 * @property int $id
 * @property string $title
 * @property int $is_column
 * @property string $person_name
 * @property string $person_image
 * @property string $person_post
 * @property int $is_discount
 * @property int $discount_type 1-процент,2-сумма
 * @property double $discount_value
 * @property string $discount_info
 * @property int $created_at
 */
class Questionnaires extends \yii\db\ActiveRecord
{
    const DISCOUNT_PROCENT = 1;
    const DISCOUNT_SUM = 2;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questionnaires';
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
            ['title', 'required'],
            [['is_column', 'is_discount', 'discount_type', 'created_at'], 'integer'],
            ['discount_value', 'number'],
            ['discount_info', 'string'],
            [['title', 'person_name', 'person_image'], 'string', 'max' => 255],
            ['person_post', 'string', 'max' => 100],
            [['person_name', 'person_image', 'person_post'], 'required', 'whenClient' => "function (attribute, value) {
                return $('#questionnaires-is_column').is(':checked');
            }"],
            [['discount_type', 'discount_value', 'discount_info'], 'required', 'whenClient' => "function (attribute, value) {
                return $('#questionnaires-is_discount').is(':checked');
            }"]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Название',
            'is_column' => 'Правая колонка',
            'person_name' => 'Имя эксперта',
            'person_image' => 'Фото эксперта',
            'person_post' => 'Должность эксперта',
            'is_discount' => 'Со скидкой',
            'discount_type' => 'Тип скидки',
            'discount_value' => 'Значение скидки',
            'discount_info' => 'Информация о скидке',
            'created_at' => 'Создано'
        ];
    }
    
    /**
     * Returns a list of discount types or name
     * 
     * @param integer $key key in an array of names
     * @return mixed
     */
    public static function getDiscountTypes($key = null)
    {
        $array = [
            self::DISCOUNT_PROCENT => 'Процент',
            self::DISCOUNT_SUM => 'Сумма'
        ];
        return is_null($key) ? $array : $array[$key];
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestions()
    {
        return $this->hasMany(Questions::className(), ['questionnaire_id' => 'id'])
            ->andWhere(['is_active' => 1])->orderBy('position ASC');
    }
    
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestionsIndexed()
    {
        return $this->hasMany(Questions::className(), ['questionnaire_id' => 'id'])
            ->andWhere(['is_active' => 1])->orderBy('position ASC')->indexBy('id');
    }
}