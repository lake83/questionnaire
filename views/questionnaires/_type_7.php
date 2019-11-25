<?php

use kartik\slider\Slider;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */

$formatter = Yii::$app->formatter;
?>

<div class="<?= $is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12 slider_field">
    <div class="col-md-6 col-sm-6">
        <b class="pull-left min"><?= $formatter->asDecimal($question['slider_min']) ?></b>
    </div>
    <div class="col-md-6 col-sm-6">
        <b class="pull-right max"><?= $formatter->asDecimal($question['slider_max']) ?></b>
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