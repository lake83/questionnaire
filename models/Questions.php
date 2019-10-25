<?php

namespace app\models;

use yii\behaviors\TimestampBehavior;
use yii\helpers\Json;

/**
 * This is the model class for table "questions".
 *
 * @property int $id
 * @property int $questionnaire_id
 * @property string $name
 * @property int $type
 * @property string $hint
 * @property string $image
 * @property string $slider
 * @property int $position
 * @property int $is_required
 * @property int $is_several
 * @property int $is_active
 * @property int $created_at
 *
 * @property Questionnaires $questionnaire
 */
class Questions extends \yii\db\ActiveRecord
{
    const TYPE_OPTIONS = 1;
    const TYPE_OPTIONS_IMGS = 2;
    const TYPE_OPTIONS_AND_IMG = 3;
    const TYPE_TEXTAREA = 4;
    const TYPE_DROPDOWN = 5;
    const TYPE_DATE = 6;
    const TYPE_SLIDER = 7;
    const TYPE_FILE = 8;
    
    public $slider_min;
    public $slider_max;
    public $slider_step;
    
    public $image_form;
    public $image_view;
    
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'questions';
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
            [['questionnaire_id', 'name', 'type', 'hint'], 'required'],
            [['questionnaire_id', 'type', 'position', 'is_required', 'is_several', 'is_active', 'created_at', 'slider_min', 'slider_max', 'slider_step'], 'integer'],
            [['name', 'hint', 'image', 'slider'], 'string', 'max' => 255],
            ['questionnaire_id', 'exist', 'skipOnError' => true, 'targetClass' => Questionnaires::className(), 'targetAttribute' => ['questionnaire_id' => 'id']],
            ['image', 'required', 'when' => function($model) {
                    return $model->type == self::TYPE_OPTIONS_AND_IMG;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#questions-type').val() == " . self::TYPE_OPTIONS_AND_IMG . ";
                }"
            ],
            [['slider_min', 'slider_max', 'slider_step'], 'required', 'when' => function($model) {
                    return $model->type == self::TYPE_SLIDER;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#questions-type').val() == " . self::TYPE_SLIDER . ";
                }"
            ],
            [['image_form', 'image_view'], 'required', 'when' => function($model) {
                    return $model->type == self::TYPE_OPTIONS_IMGS;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#questions-type').val() == " . self::TYPE_OPTIONS_IMGS . ";
                }"
            ],
            ['position', 'default', 'value' => 0],
            ['slider', 'default', 'value' => '']
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
            'name' => 'Вопрос',
            'type' => 'Тип вопроса',
            'hint' => 'Подсказка консультанта',
            'image' => 'Картинка',
            'image_form' => 'Формат изображения',
            'image_view' => 'Расположение изображения',
            'slider_min' => 'Ползунок минимум',
            'slider_max' => 'Ползунок максимум',
            'slider_step' => 'Ползунок шаг',
            'position' => 'Позиция',
            'is_required' => 'Обязательный вопрос',
            'is_several' => 'Можно несколько',
            'is_active' => 'Активно',
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
     * Returns a list of types or name
     * 
     * @param integer $key key in an array of names
     * @return mixed
     */
    public static function getTypes($key = null)
    {
        $array = [
            self::TYPE_OPTIONS => 'Варианты ответов',
            self::TYPE_OPTIONS_IMGS => 'Варианты с картинками',
            self::TYPE_OPTIONS_AND_IMG => 'Варианты и картинка',
            self::TYPE_TEXTAREA => 'Своё поле для ввода',
            self::TYPE_DROPDOWN => 'Выпадающий список',
            self::TYPE_DATE => 'Дата',
            self::TYPE_SLIDER => 'Ползунок',
            self::TYPE_FILE => 'Загрузка файла'
        ];
        return is_null($key) ? $array : $array[$key];
    }
    
    /**
     * Returns a list of images form or name
     * 
     * @param integer $key key in an array of names
     * @return mixed
     */
    public static function getImagesForm($key = null)
    {
        $array = [
            1 => 'Вертикально',
            2 => 'Квадрат',
            3 => 'Горизонтально'
        ];
        return is_null($key) ? $array : $array[$key];
    }
    
    /**
     * Returns a list of images view or name
     * 
     * @param integer $key key in an array of names
     * @return mixed
     */
    public static function getImagesView($key = null)
    {
        $array = [
            1 => 'Слайдер',
            2 => 'Плиткой'
        ];
        return is_null($key) ? $array : $array[$key];
    }
    
    /**
     * @inheritdoc
     */
    public function afterFind()
    {
        if ((int)$this->type == self::TYPE_SLIDER) {
            $slider = Json::decode($this->slider);
            $this->slider_min = $slider['min'];
            $this->slider_max = $slider['max'];
            $this->slider_step = $slider['step'];
        }
        if ((int)$this->type == self::TYPE_OPTIONS_IMGS) {
            $imgs = Json::decode($this->image);
            $this->image_form = $imgs['form'];
            $this->image_view = $imgs['view'];
        }
        parent::afterFind();
    }
    
    /**
     * @inheritdoc
     */
    public function beforeSave($insert)
    {
        if ((int)$this->type == self::TYPE_SLIDER) {
            $this->slider = Json::encode(['min' => $this->slider_min, 'max' => $this->slider_max, 'step' => $this->slider_step]);
        } else {
            $this->slider = '';
        }
        if ((int)$this->type == self::TYPE_OPTIONS_IMGS) {
            $this->image = Json::encode(['form' => $this->image_form, 'view' => $this->image_view]);
        } elseif ((int)$this->type !== self::TYPE_OPTIONS_AND_IMG) {
            $this->image = '';
        }
        return parent::beforeSave($insert);
    }
}