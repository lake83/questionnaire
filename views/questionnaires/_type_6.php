<?php

use kartik\field\FieldRange;
use kartik\datetime\DateTimePicker;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="row col-md-6 col-sm-6 col-xs-12">
<?= $form->field($data, 'field_' . $question['id'], [
        'labelOptions' => ['style' => 'margin: 20px 0 30px 20px;font-size:14px']
    ])->widget(DateTimePicker::classname(), [
	'type' => DateTimePicker::TYPE_COMPONENT_APPEND,
    'removeButton' => false,
    'options' => ['style' => 'border-right: none;'],
    'pluginOptions' => [
		'autoclose' => true,
        'format' => 'd MM yyyy hh:ii',
        'pickerPosition' => 'bottom-left'
	]
])->label('Выберите дату')->error(false) ?>
</div>