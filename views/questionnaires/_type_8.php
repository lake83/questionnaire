<?php

use kartik\file\FileInput;

/* @var array $question */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */
/* @var boolean $is_column */
?>

<div class="file_wrap <?= $is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12">
<?= $form->field($data, 'field_' . $question['id'] . '[]')->widget(FileInput::classname(), [
    'language' => 'ru',
    'options' => ['multiple' => true, 'accept' => 'image/*'],
    'pluginOptions' => [
        'previewFileType' => 'image',
        'allowedFileExtensions' => ['jpg', 'jpeg', 'png', 'JPG', 'JPEG', 'PNG'],
        'showCaption' => false,
        'showRemove' => false,
        'showUpload' => false,
        'showBrowse' => false,
        'maxFileSize' => 2000,
        'maxFileCount' => 3,
        'browseOnZoneClick' => true,
        'dropZoneTitle' => '<img src="/images/file_upload.png"><br />' . $question['file_main_text'] . '<br />',
        'dropZoneClickTitle' => '<span>' . $question['file_help_text'] . '</span>'
    ]
])->label(false)->error(false) ?>
</div>
<div class="clearfix"></div>