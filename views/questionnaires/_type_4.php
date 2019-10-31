<?php

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
?>

<div class="row col-md-11 col-xs-12">
<?= $form->field($data, 'field_' . $question['id'])->textarea(['rows' => 5, 'style' => 'resize:none'])->label(false)->error(false) ?>
</div>