<?php

use yii\helpers\ArrayHelper;
use app\components\SiteHelper;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
/* @var boolean $is_column */

\app\assets\SlickAsset::register($this);

$items = $is_column ? ($question['image_form'] == 1 ? 4 : 3) : ($question['image_form'] == 1 ? 5 : 4);

$this->registerJs("$('#dynamicmodel-field_" . $question['id'] . "').slick({
  slidesToShow: " . $items . ",
  slidesToScroll: 1,
  dots: true,
  responsive: [
    {
      breakpoint: 1200,
      settings: {
        slidesToShow: " . $items . ",
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 992,
      settings: {
        slidesToShow: " . $items . ",
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 768,
      settings: {
        slidesToShow: 3,
        slidesToScroll: 1
      }
    },
    {
      breakpoint: 575,
      settings: {
        slidesToShow: 1,
        slidesToScroll: 1
      }
    }
  ]
});");
?>

<div class="row <?= $is_column ? 'col-md-11' : 'col-md-12' ?> col-xs-12 with_imgs">
    <?= $form->field($data, 'field_' . $question['id'])->checkboxList(ArrayHelper::map(($options = $question->options), 'id', 'name'), [
        'item' => function($index, $label, $name, $checked, $value) use ($question, $options){
            return '<div class="type_options ' . ($question['image_form'] == 1 ? 'col-md-3 col-sm-3' : 'col-md-4 col-sm-4') . ' col-xs-12">
                <img class="type_options_and_img" src="' . ($question['image_form'] == 1 ? SiteHelper::resized_image($options[$value]['image'], 200, 200) :
                    SiteHelper::resized_image($options[$value]['image'], 200, 150)) . '" alt="' . $options[$value]['name'] . '" />
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="' . $name . '" value="' . $value . '">
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>' . $label . '
                    </label>
                </div>
            </div>';
        },
        //'data-slick' => '{"slidesToShow": 3, "slidesToScroll": 3}'
    ])->label(false)->error(false) ?>
</div>