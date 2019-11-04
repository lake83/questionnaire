<?php

use kartik\field\FieldRange;
use kartik\datetime\DateTimePicker;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="row col-md-11 col-sm-12 col-xs-12">
<?php 
echo FieldRange::widget([
    'id' => 'datetime-range_' . $question['id'],
    'form' => $form,
    'model' => $data,
    'useAddons' => false,
    'template' => '{widget}',
    'separator' => '&larr; до &rarr;',
    'separatorOptions' => ['style' => 'padding: 15px 12px;'],
    'label' => '',
    'attribute1' => 'datetime_start_' . $question['id'],
    'widgetOptions1' => [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'd MM yyyy hh:ii'
        ],
        'type' => DateTimePicker::TYPE_COMPONENT_PREPEND
    ],
    'attribute2' => 'datetime_end_' . $question['id'],
    'widgetOptions2' => [
        'pluginOptions' => [
            'autoclose' => true,
            'format' => 'd MM yyyy hh:ii',
            'pickerPosition' => 'bottom-left'
        ],
        'type' => DateTimePicker::TYPE_COMPONENT_APPEND
    ],
    'type' => FieldRange::INPUT_DATETIME
]);

echo $form->field($data, 'field_' . $question['id'])->hiddenInput()->label(false)->error(false) ?>
</div>