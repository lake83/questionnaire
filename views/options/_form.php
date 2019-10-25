<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\models\Questions;

/* @var $this yii\web\View */
/* @var $model app\models\Options */
/* @var $form yii\bootstrap\ActiveForm */

$request = Yii::$app->request;

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'question_id')->hiddenInput(['value' => $request->get('question_id')])->label(false) ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <div<?= (int)$request->get('type') !== Questions::TYPE_OPTIONS_IMGS ? ' style="display:none"' : '' ?>>
        <?= $form->field($model, 'image')->widget(\app\components\FilemanagerInput::className()) ?>
    </div>

    <?= $form->field($model, 'position')->textInput() ?>

    <?= $form->field($model, 'is_active')->checkbox() ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>