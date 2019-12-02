<?php

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="<?= $is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12 textarea_wrap">
<?= $form->field($data, 'field_' . $question['id'])->textarea(['rows' => 6, 'style' => 'resize:none', 'placeholder' => $question['textarea_placeholder']])->label(false)->error(false) ?>
</div>