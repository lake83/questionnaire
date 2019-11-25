<?php

use kartik\field\FieldRange;
use kartik\datetime\DateTimePicker;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="row col-md-6 col-sm-6 col-xs-12" style="margin: 15px;">
<?= $form->field($data, 'field_' . $question['id'])->widget(DateTimePicker::classname(), [
	'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
    'removeButton' => false,
    'options' => ['style' => 'border-right: none;'],
    'pluginOptions' => [
		'autoclose' => true,
        'format' => 'd MM yyyy hh:ii',
        'pickerPosition' => 'bottom-left'
	]
])->label(false)->error(false) ?>
</div>