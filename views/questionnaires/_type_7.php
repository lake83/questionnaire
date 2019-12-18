<?php

use kartik\slider\Slider;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */

$formatter = Yii::$app->formatter;
?>

<div class="<?= $is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12 slider_field">
    <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
        <label for="slider_min_title"><?= $question['slider_min_title'] ?></label>
        <b class="pull-left min"><strong><?= $formatter->asDecimal($question['slider_min']) . '</strong>' . ($mark = $question['slider_mark'] ? ' <span>' . $question['slider_mark'] . '</span>' : '') ?></b>
    </div>
    <div class="col-md-6 col-sm-6 col-xs-12 no-padding">
        <b class="pull-right max"><label for="slider_max_title"><?= $question['slider_max_title'] ?></label><strong><?= $formatter->asDecimal($question['slider_max']) . '</strong>' . $mark ?></b>
    </div>
        <?= $form->field($data, 'field_' . $question['id'])->widget(Slider::classname(), [
            'sliderColor' => '#dc2d3e',
            'pluginOptions' => [
                'min' => $question['slider_min'],
                'max' => $question['slider_max'],
                'step' => $question['slider_step'],
                'range' => true,
                'handle' => 'custom',
                'formatter' => new yii\web\JsExpression("function(val) {return formatSlider(val)}")
            ]
        ])->label(false)->error(false) ?>
</div>