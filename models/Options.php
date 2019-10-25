<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "options".
 *
 * @property int $id
 * @property int $question_id
 * @property string $name
 * @property string $image
 * @property int $position
 * @property int $is_active
 *
 * @property Questions $question
 */
class Options extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'options';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['question_id', 'name'], 'required'],
            [['question_id', 'position', 'is_active'], 'integer'],
            [['name', 'image'], 'string', 'max' => 255],
            [['question_id'], 'exist', 'skipOnError' => true, 'targetClass' => Questions::className(), 'targetAttribute' => ['question_id' => 'id']],
            ['position', 'default', 'value' => 0],
            ['image', 'required', 'when' => function($model) {
                    return Yii::$app->request->get('type') == Questions::TYPE_OPTIONS_IMGS;
                }, 'whenClient' => "function (attribute, value) {
                    return " . Yii::$app->request->get('type') . " == " . Questions::TYPE_OPTIONS_IMGS . ";
                }"
            ]
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'question_id' => 'Вопрос',
            'name' => 'Опция',
            'image' => 'Картинка',
            'position' => 'Позиция',
            'is_active' => 'Активно'
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getQuestion()
    {
        return $this->hasOne(Questions::className(), ['id' => 'question_id']);
    }
}