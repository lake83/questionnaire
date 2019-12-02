<?php

use app\components\SiteHelper;
use yii\bootstrap\ActiveForm;
use yii\helpers\Url;

/* @var $this yii\web\View */
/* @var $model app\models\Questionnaires */
/* @var array $questions */
/* @var $data yii\base\DynamicModel */
/* @var $form yii\bootstrap\ActiveForm */

\app\assets\QuestionnaireAsset::register($this);
?>

<div class="main-wrapper">
    <div class="main-col"<?= $model->is_column ? '' : ' style="width:100%"' ?>>
        <div class="q_title"><img src="/images/title.png" /><?= $model->title ?></div>
        
        <?php $form = ActiveForm::begin([
            'action' => Url::to(['questionnaires/view', 'id' => $model->id], true),
            'validateOnType' => true,
            'options' => ['enctype' => 'multipart/form-data']
        ]); ?>
        <div class="q_content">
            <?php if ($questions): $step = ceil(100/($steps = count($questions))); $formatter = Yii::$app->formatter; ?>
                
                <?php if ($model->is_column): ?>
                <div class="m_second-col visible-xs">
                
                <?php $this->beginBlock('second-col', true); ?>
        
                    <div class="person_img" style="background-image: url('<?= SiteHelper::resized_image($model->person_image, 70, null) ?>');"></div>
                    <strong><?= $model->person_name ?></strong>
                    <small><?= $model->person_post ?></small>
        
                    <div class="clearfix"></div>
                    <div class="description"><div class="triangle"></div><span><?= isset($questions[0]) ? $questions[0]['hint'] : '' ?></span></div>
        
                    <?php if ($model->is_discount): ?>
                    <div class="discount">
                        <img src="/images/wallet.png" />
                        <img class="discount_info" src="/images/info.png" title="<?= $model->discount_info ?>" />
                        <span>Ваша скидка</span>
                        <strong data-answers="0">0 <?= $model->discount_type == $model::DISCOUNT_PROCENT ? '%' : 'р.' ?></strong>
                    </div>
                    <?php endif ?>
        
                <?php $this->endBlock(); ?>
        
                </div>
                <?php endif ?>
                
                <?php foreach ($questions as $key => $question): ?>
                    <div class="q_content_block"<?= $key>0 ? ' style="display:none"' : '' ?> id="<?= $key ?>" data-hint="<?= $question['hint'] ?>" data-progress="<?= $step*$key ?>"
                        <?php $discont = round(($model->discount_value/$steps)*$key, 2); echo $model->is_discount ? ' data-discount="' . ($model->discount_type == $model::DISCOUNT_PROCENT ?
                        $discont . ' %' : $formatter->asCurrency($discont, 'RUR', [\NumberFormatter::MAX_FRACTION_DIGITS => 0])) . '"' : '' ?>>
                        
                        <h3><?= $question['name'] ?></h3>
                        <div class="q_info col-md-12">
                            <div class="col-md-11 col-sm-11 col-xs-12">
                                <div class="checkbox note_check"><span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span></div>
                                <div class="note note_box"><?= $question['info'] ?></div>
                                <?= !$question['is_required'] ? '<div class="note note_required">Можно пропустить</div>' : '' ?>
                            </div>
                        </div>
                        <div class="checkbox"></div>
                        
                        <?= $this->render('_type_' . $question['type'], ['form' => $form, 'data' => $data, 'question' => $question, 'is_column' => $model->is_column]) ?>
                                                
                    </div>
                <?php endforeach ?>
                <div id="<?= $key+1 ?>" class="test_done" data-hint="Введите данные, чтобы мы могли с вами связаться." data-progress="100"
                    <?php $discont = round($model->discount_value, 2); echo $model->is_discount ? ' data-discount="' .
                    ($model->discount_type == $model::DISCOUNT_PROCENT ? $discont . ' %' :
                    $formatter->asCurrency($discont, 'RUR', [\NumberFormatter::MAX_FRACTION_DIGITS => 0])) . '"' : '' ?> style="display:none">
                    
                    <span>Отлично, вы завершили тест!</span>
                    <h3>Введите ваши контактные данные</h3>
                    
                    <div class="row <?= $model->is_column ? 'col-md-11 col-sm-11' : 'col-md-12 col-sm-12' ?> col-xs-12 no-padding" style="margin: 30px 0;">
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
                                <span class="cr"><i class="cr-icon glyphicon glyphicon-ok"></i></span>Принимаю <a href="<?= Url::to(['site/conditions'], true) ?>" target="_blank">условия обработки данных</a> 
                            </label>
                        </div>
                    </div>
                </div>
                
                <?php if ($model->is_discount) {
                    echo $form->field($data, 'discount')->hiddenInput(['value' => 0])->label(false)->error(false);
                }
                echo $form->field($data, 'referrer')->hiddenInput()->label(false)->error(false); ?>
            <?php else: ?>
                <p>Опрос не содержит активных вопросов.</p>
            <?php endif ?>
        </div>
        
        <div class="q_buttons">
            <div class="progress_wrap">
                <small>Готово на <span>0</span>%</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100" style="width:0%"></div>
                </div>
            </div>
            <div class="btn_wrap"<?= !$model->is_column ? ' style="text-align: right;"' : '' ?>>
                <button id="prev" type="button" class="btn btn-light btn-lg"></button>
                <button id="next" type="button" class="btn btn-danger btn-lg">Далее<span></span></button>
                <button id="send" type="submit" class="btn btn-danger btn-lg">Отправить<span></span></button>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>

    <?php if ($model->is_column): ?>
    <div class="second-col hidden-xs">
        
        <?= $this->blocks['second-col']; ?>
        
    </div>
    <?php endif ?>
</div>