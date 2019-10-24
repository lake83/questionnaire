<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/* @var $this yii\web\View */
/* @var $model app\models\Questions */
/* @var $form yii\bootstrap\ActiveForm */

$form = ActiveForm::begin(['layout' => 'horizontal']); ?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_column')->checkbox() ?>

    <?= $form->field($model, 'person_name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'person_image')->widget(\app\components\FilemanagerInput::className()) ?>

    <?= $form->field($model, 'person_post')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'is_discount')->checkbox() ?>

    <?= $form->field($model, 'discount_type')->dropDownList($model->getDiscountTypes(), ['prompt' => '- выбрать -']) ?>

    <?= $form->field($model, 'discount_value')->textInput() ?>

    <?= $form->field($model, 'discount_info')->textarea(['rows' => 6]) ?>

    <div class="box-footer">
        <?= Html::submitButton($model->isNewRecord ? 'Создать' : 'Сохранить', ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

<?php ActiveForm::end(); ?>