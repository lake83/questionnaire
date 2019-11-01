<?php

use app\components\SiteHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;
use app\models\Questions;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaires */
/* @var array $questions */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */

\app\assets\QuestionnaireAsset::register($this);
?>

<div class="main-wrapper">
    <div class="main-col <?= $model->is_column ? 'col-md-10 col-sm-10' : 'col-md-12' ?> col-xs-12 no-padding">
        <div class="q_title"><img src="/images/title.png" /><?= $model->title ?></div>
        
        <?php $form = ActiveForm::begin(['action' => Url::to(['questionnaires/view', 'id' => $model->id], true), 'validateOnType' => true]); ?>
        <div class="q_content">
            <?php if ($questions): $step = ceil(100/($steps = count($questions))); $formatter = Yii::$app->formatter; ?>
                
                <?php foreach ($questions as $key => $question): ?>
                    <div<?= $key>0 ? ' style="display:none"' : '' ?> id="<?= $key ?>" data-hint="<?= $question['hint'] ?>" data-progress="<?= $step*$key ?>"
                        <?php $discont = round(($model->discount_value/$steps)*$key, 2); echo $model->is_discount ? ' data-discount="' . ($model->discount_type == $model::DISCOUNT_PROCENT ?
                        $discont . ' %' : $formatter->asCurrency($discont, 'RUR', [\NumberFormatter::MAX_FRACTION_DIGITS => 0])) . '"' : '' ?>>
                        
                        <h3><?= $question['name'] ?></h3>
                        <div class="q_info col-md-12">
                            <div class="col-md-5 col-sm-5 col-xs-12">
                                <div class="checkbox"><span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span></div>
                                <?= ($question['type'] == Questions::TYPE_OPTIONS ||
                                $question['type'] == Questions::TYPE_OPTIONS_IMGS || $question['type'] == Questions::TYPE_OPTIONS_AND_IMG) ?
                                ($question['is_several'] ? 'Выберите один или несколько' : 'Выберите вариант') :
                                Questions::getTypesInfo($question['type']) ?>
                            </div>
                            <div class="col-md-5 col-sm-5 col-xs-12"><?= !$question['is_required'] ? 'Можно пропустить' : '' ?></div>
                        </div>
                        
                        <?= $this->render('_type_' . $question['type'], ['form' => $form, 'data' => $data, 'question' => $question, 'is_column' => $model->is_column]) ?>
                                                
                    </div>
                <?php endforeach ?>
                <div id="<?= $key+1 ?>" class="test_done" data-hint="Введите данные, чтобы мы могли с вами связаться." data-progress="100"
                    <?php $discont = round($model->discount_value, 2); echo $model->is_discount ? ' data-discount="' .
                    ($model->discount_type == $model::DISCOUNT_PROCENT ? $discont . ' %' :
                    $formatter->asCurrency($discont, 'RUR', [\NumberFormatter::MAX_FRACTION_DIGITS => 0])) . '"' : '' ?> style="display:none">
                    
                    <span>Отлично, вы завершили тест!</span>
                    <h3>Введите ваши контактные данные</h3>
                    
                    <div class="row col-md-11 col-xs-12">
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($data, 'name')->textInput()->label('Ваше имя')->error(false) ?>
                        </div>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <?= $form->field($data, 'phone')->widget(\yii\widgets\MaskedInput::className(), ['mask' => Yii::$app->params['phone_mask']])->label('Номер телефона')->error(false) ?>
                        </div>
                    </div>
                    <div class="col-md-11 col-xs-12">
                        <div class="checkbox">
                            <label>
                                <input type="checkbox" id="dynamicmodel-conditions" name="conditions" value="1" checked="checked">
                                <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>Принимаю условия обработки данных
                            </label>
                        </div>
                    </div>
                </div>
                
            <?php else: ?>
                <p>Опрос не содержит активных вопросов.</p>
            <?php endif ?>
        </div>
        
        <div class="row q_buttons">
            <div class="col-md-8 col-sm-7 col-xs-12">
                <small>Готово на <span>0</span>%</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                </div>
            </div>
            <div class="col-md-4 col-sm-5 col-xs-12">
                <button id="prev" type="button" class="btn btn-light btn-lg"></button>
                <button id="next" type="button" class="btn btn-danger btn-lg">Далее<span></span></button>
                <button id="send" type="submit" class="btn btn-danger btn-lg" style="display:none">Отправить<span></span></button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <?php if ($model->is_column): ?>
    <div class="second-col col-md-2 col-sm-2 col-xs-12 no-padding">
        <div class="person_img" style="background-image: url('<?= SiteHelper::resized_image($model->person_image, 70, null) ?>');"></div>
        <?= $model->person_name ?>
        <small><?= $model->person_post ?></small>
        
        <div class="clearfix"></div>
        <div class="description"><?= isset($questions[0]) ? $questions[0]['hint'] : '' ?></div>
        
        <?php if ($model->is_discount): ?>
        <div class="discount">
            <img src="/images/wallet.png" />
            <img class="discount_info" src="/images/info.png" title="<?= $model->discount_info ?>" />
            Ваша скидка
            <strong>0 <?= $model->discount_type == $model::DISCOUNT_PROCENT ? '%' : 'р.' ?></strong>
        </div>
        <?php endif ?>
    </div>
    <?php endif ?>
</div>