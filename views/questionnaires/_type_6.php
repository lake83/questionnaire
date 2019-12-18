<?php

use kartik\field\FieldRange;
use kartik\date\DatePicker;
use kartik\time\TimePicker;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="row <?= $is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12 no-padding">
<div class="col-md-6 col-sm-6 col-xs-12">
<label style="margin: 20px 0 30px 20px;font-size:14px" for="date-field">Выберите дату</label>
<?= DatePicker::widget([
	'id' => 'date-field',
    'name' => 'date',
	'type' => DatePicker::TYPE_COMPONENT_APPEND,
    'removeButton' => false,
    'options' => ['style' => 'border-right: none;'],
    'pluginOptions' => [
        'autoclose' => true,
        'format' => 'd MM yyyy',
        'pickerPosition' => 'bottom-left'
    ]
]) ?>
</div>

<div class="col-md-6 col-sm-6 col-xs-12">
<label style="margin: 20px 0 30px 20px;font-size:14px" for="time-field">Выберите время</label>
<?= TimePicker::widget([
    'id' => 'time-field',
    'name' => 'time',
    'pluginOptions' => [
        'showMeridian' => false
    ]
]) ?>
</div>
<?= $form->field($data, 'field_' . $question['id'])->hiddenInput()->error(false)->label(false) ?>
</div>