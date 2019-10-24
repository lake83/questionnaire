<?php

use app\components\SiteHelper;

/* @var $this yii\web\View */
/* @var $model app\models\Questions */

app\assets\QuestionnaireAsset::register($this);
?>

<div class="main-wrapper">
    <div class="main-col <?= $model->is_column ? 'col-md-10 col-sm-10' : 'col-md-12' ?> col-xs-12 no-padding">
        <div class="q_title"><img src="/images/title.png" /><?= $model->title ?></div>
        <div class="row q_content"></div>
        <div class="row q_buttons">
            <div class="col-md-8 col-sm-8 col-xs-12">
                <small>Готово на 40%</small>
                <div class="progress">
                    <div class="progress-bar progress-bar-striped active" role="progressbar" aria-valuenow="40" aria-valuemin="0" aria-valuemax="100" style="width:40%"></div>
                </div>
            </div>
            <div class="col-md-4 col-sm-4 col-xs-12">
                <button type="button" class="btn btn-light btn-lg"></button>
                <button type="button" class="btn btn-danger btn-lg">Далее<span></span></button>
            </div>
        </div>
    </div>

    <?php if ($model->is_column): ?>
    <div class="second-col col-md-2 col-sm-2 col-xs-12 no-padding">
        <div class="person_img" style="background-image: url('<?= SiteHelper::resized_image($model->person_image, 70, null) ?>');"></div>
        <?= $model->person_name ?>
        <small><?= $model->person_post ?></small>
        
        <div class="clearfix"></div>
        <div class="description">Вы думаете, в архитектуре важна форма: углы, фигуры? Нет. В архитектуре важно напряжение между элементами!</div>
        
        <?php if ($model->is_discount): $formatter = Yii::$app->formatter; ?>
        <div class="discount">
            <img src="/images/wallet.png" /><br />
            <img class="discount_info" src="/images/info.png" title="<?= $model->discount_info ?>" />
            Ваша скидка
            <strong><?= $model->discount_type == $model::DISCOUNT_PROCENT ? $formatter->asPercent($model->discount_value, 2) :
                $formatter->asCurrency($model->discount_value, 'RUR', [\NumberFormatter::MAX_FRACTION_DIGITS => 0]); ?>
            </strong>
        </div>
        <?php endif ?>
    </div>
    <?php endif ?>
</div>