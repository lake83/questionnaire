<?php

use yii\helpers\ArrayHelper;
use kartik\select2\Select2;
use yii\helpers\Html;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
/* @var boolean $is_column */
?>

<div class="<?= $is_column ? 'col-md-11' : 'col-md-12' ?> col-xs-12">
    <?= $form->field($data, 'field_' . $question['id'])->widget(Select2::classname(), [
        'data' => ArrayHelper::map($question->options, 'id', 'name'),
        'size' => Select2::LARGE,
        'theme' => Select2::THEME_BOOTSTRAP,
        'options' => ['placeholder' => '- выбрать -'],
        'pluginOptions' => [
            'allowClear' => true,
            'minimumResultsForSearch' => -1
        ]
    ])->label(false)->error(false) ?>
</div>