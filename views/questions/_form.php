<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questions */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'questionnaire_id')->hiddenInput(['value' => Yii::$app->request->get('questionnaire_id')])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'type', ['enableAjaxValidation' => true])->dropDownList($model->getTypes(), [
        'prompt' => '- выбрать -',
        'onchange' => 'if (this.value == ' . $model::TYPE_OPTIONS_AND_IMG .
            ') {$(".options_image").show()} else {$(".options_image").hide();$("#questions-image").val("")}
            if (this.value == ' . $model::TYPE_OPTIONS_IMGS .
            ') {$(".images").show()} else {$(".images").hide();$("#questions-image_form").val("")}
            if (this.value == ' . $model::TYPE_FILE .
            ') {$(".files").show()} else {$(".files").hide();$("#questions-file_main_text, #questions-file_help_text").val("")}
            if (this.value == ' . $model::TYPE_TEXTAREA .
            ') {$(".texarea").show()} else {$(".texarea").hide();$("#questions-textarea_placeholder").val("")}
            if (this.value == ' . $model::TYPE_SLIDER .
            ') {$(".slider").show()} else {$(".slider").hide();$("#questions-slider_min, #questions-slider_max, #questions-slider_step").val("")}
            if (this.value == ' . $model::TYPE_OPTIONS . ' || this.value == ' . $model::TYPE_OPTIONS_IMGS .
            ' || this.value == ' . $model::TYPE_OPTIONS_AND_IMG .
            ') {$(".several").show()} else {$(".several").hide();$("#questions-is_several").val("0")}'
    ]) ?>
    
    <?= $form->field($model, 'info')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'hint')->textInput(['maxlength' => true]) ?>

    <div class="options_image"<?= $model->isNewRecord || $model->type !== $model::TYPE_OPTIONS_AND_IMG ? ' style="display:none"' : '' ?>>
        <?= $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className()) ?>
    </div>
    
    <div class="images"<?= $model->isNewRecord || $model->type !== $model::TYPE_OPTIONS_IMGS ? ' style="display:none"' : '' ?>>
        <?= $form->field($model, 'image_form')->dropDownList($model->getImagesForm(), ['prompt' => '- выбрать -']) ?>
    </div>
    
    <div class="files"<?= $model->isNewRecord || $model->type !== $model::TYPE_FILE ? ' style="display:none"' : '' ?>>
        <?= $form->field($model, 'file_main_text')->textInput(['maxlength' => true]) ?>
        <?= $form->field($model, 'file_help_text')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="texarea"<?= $model->isNewRecord || $model->type !== $model::TYPE_TEXTAREA ? ' style="display:none"' : '' ?>>
        <?= $form->field($model, 'textarea_placeholder')->textInput(['maxlength' => true]) ?>
    </div>
    
    <div class="slider"<?= $model->isNewRecord || $model->type !== $model::TYPE_SLIDER ? ' style="display:none"' : '' ?>>
        <?= $form->field($model, 'slider_min')->textInput() ?>
        <?= $form->field($model, 'slider_max')->textInput() ?>
        <?= $form->field($model, 'slider_step')->textInput() ?>
    </div>
    
    <?= $form->field($model, 'position')->textInput() ?>

    <?= $form->field($model, 'is_required')->checkbox() ?>

    <div class="several"<?= $model->isNewRecord || ($model->type !== $model::TYPE_OPTIONS && $model->type !== $model::TYPE_OPTIONS_IMGS &&
        $model->type !== $model::TYPE_OPTIONS_AND_IMG) ? ' style="display:none"' : '' ?>>
        <?= $form->field($model, 'is_several')->checkbox() ?>
    </div>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>