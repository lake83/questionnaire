<?php

use kartik\file\FileInput;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
/* @var boolean $is_column */
?>

<div class="<?= $is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12" style="margin-top: 15px;height: 180px;">
<?= $form->field($data, 'field_' . $question['id'] . '[]')->widget(FileInput::classname(), [
    'language' => 'ru',
    'options' => ['multiple' => true, 'accept' => 'image/*'],
    'pluginOptions' => [
        'previewFileType' => 'image',
        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'],
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'browseClass' => 'btn btn-block',
        'browseIcon' => '<i class="glyphicon glyphicon-camera"></i> ',
        'browseLabel' => $question['file_button'],
        'maxFileSize' => 2000,
        'maxFileCount' => 3,
        'showUpload' => false       
    ]
])->label(false)->error(false) ?>
</div>
<div class="clearfix"></div>