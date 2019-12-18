<?php

use yii\helpers\ArrayHelper;
use app\components\SiteHelper;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
/* @var boolean $is_column */
?>

<div class="<?= $is_column ? 'col-md-5 col-sm-5' : 'col-md-6 col-sm-6' ?> col-xs-12 type_options_and_img_check no-padding">
    <?= $form->field($data, 'field_' . $question['id'])->checkboxList(ArrayHelper::map($question->options, 'id', 'name'), [
        'item' => function($index, $label, $name, $checked, $value) {
            return '<div class="type_options no-padding col-md-12">
                <div class="checkbox">
                    <label>
                        <input type="checkbox" name="' . $name . '" value="' . $value . '">
                        <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>' . $label . '
                    </label>
                </div>
            </div>';
        }
    ])->label(false)->error(false) ?>
</div>
<div class="type_options_and_img_wrap col-md-6 col-sm-6 col-xs-12"<?= $is_column ? '' : ' style="margin: 0;"' ?>>
    <img class="type_options_and_img" src="<?= SiteHelper::resized_image($question['image'], 400, null) ?>" alt="<?= $question['name'] ?>" />
</div>