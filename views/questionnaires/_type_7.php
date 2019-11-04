<?php

use kartik\slider\Slider;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="<?= $is_column ? 'col-md-11' : 'col-md-12' ?> col-xs-12 slider_field">
    <b class="min"><?= $question['slider_min'] ?></b><b class="pull-right max"><?= $question['slider_max'] ?></b>
        <?= $form->field($data, 'field_' . $question['id'])->widget(Slider::classname(), [
            'sliderColor' => '#dc2d3e',
            'pluginOptions' => [
                'min' => (int)$question['slider_min'],
                'max' => (int)$question['slider_max'],
                'step' => (int)$question['slider_step'],
                'range' => true,
                'handle' => 'custom'
            ]
        ])->label(false)->error(false) ?>
</div>