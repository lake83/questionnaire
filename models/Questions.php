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
 * @property string $info
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
    
    public $file_button;
    
    public $textarea_placeholder;
    
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
            [['questionnaire_id', 'name', 'type', 'info', 'hint'], 'required'],
            [['questionnaire_id', 'type', 'position', 'is_required', 'is_several', 'is_active', 'created_at', 'slider_min', 'slider_max', 'slider_step'], 'integer'],
            [['name', 'hint', 'image', 'slider'], 'string', 'max' => 255],
            [['info', 'file_button', 'textarea_placeholder'], 'string', 'max' => 100],
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
            [['image_form'], 'required', 'when' => function($model) {
                    return $model->type == self::TYPE_OPTIONS_IMGS;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#questions-type').val() == " . self::TYPE_OPTIONS_IMGS . ";
                }"
            ],
            [['file_button'], 'required', 'when' => function($model) {
                    return $model->type == self::TYPE_FILE;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#questions-type').val() == " . self::TYPE_FILE . ";
                }"
            ],
            [['textarea_placeholder'], 'required', 'when' => function($model) {
                    return $model->type == self::TYPE_TEXTAREA;
                }, 'whenClient' => "function (attribute, value) {
                    return $('#questions-type').val() == " . self::TYPE_TEXTAREA . ";
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
            'info' => 'Информация',
            'hint' => 'Подсказка консультанта',
            'image' => 'Картинка',
            'image_form' => 'Формат изображения',
            'slider_min' => 'Ползунок минимум',
            'slider_max' => 'Ползунок максимум',
            'slider_step' => 'Ползунок шаг',
            'file_button' => 'Текст кнопки',
            'textarea_placeholder' => 'Текст плейсхолдера',
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
     * @return \yii\db\ActiveQuery
     */
    public function getOptions()
    {
        return $this->hasMany(Options::className(), ['question_id' => 'id'])
            ->andWhere(['is_active' => 1])->orderBy('position ASC')->indexBy('id')->asArray();
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
            1 => 'Квадрат',
            2 => 'Прямоугольник'
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
            $this->slider_min = (int)$slider['min'];
            $this->slider_max = (int)$slider['max'];
            $this->slider_step = (int)$slider['step'];
        }
        if ((int)$this->type == self::TYPE_OPTIONS_IMGS) {
            $imgs = Json::decode($this->image);
            $this->image_form = (int)$imgs['form'];
        }
        if ((int)$this->type == self::TYPE_FILE) {
            $file_button = Json::decode($this->image);
            $this->file_button = $file_button['btn_text'];
        }
        if ((int)$this->type == self::TYPE_TEXTAREA) {
            $textarea_placeholder = Json::decode($this->image);
            $this->textarea_placeholder = $textarea_placeholder['plc_text'];
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
            $this->image = Json::encode(['form' => $this->image_form]);
        }
        if ((int)$this->type == self::TYPE_FILE) {
            $this->image = Json::encode(['btn_text' => $this->file_button]);
        }
        if ((int)$this->type == self::TYPE_TEXTAREA) {
            $this->image = Json::encode(['plc_text' => $this->textarea_placeholder]);
        }
        return parent::beforeSave($insert);
    }
}