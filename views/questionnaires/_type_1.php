<?php

use yii\helpers\ArrayHelper;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
/* @var boolean $is_column */
?>

<div class="<?= $is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12 type_options_check no-padding">
    <?= $form->field($data, 'field_' . $question['id'])->checkboxList(ArrayHelper::map($question->options, 'id', 'name'), [
        'item' => function($index, $label, $name, $checked, $value) {
            return '<div class="type_options col-md-6 col-sm-6 col-xs-12">
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