<?
use yii\helpers\Html;
use app\models\forms\UploadForm;
use yii\widgets\ActiveForm;
use app\helpers\Normalize;
use yii\widgets\LinkPager;

/**
 * @var $models \app\models\Reviews[]
 * @var $pagination \yii\data\Pagination
 */
?>
<ul class="reviews-list">
    <? foreach ($models AS $model): ?>
        <? $date_name = Normalize::getDateByTime($model->created) . ', ' . $model->name; ?>
        <li class="reviews-list-item">
            <span class="review-img">
                <? $img_name = $model->img_name ? UploadForm::getSrc($model->img_name, UploadForm::TYPE_REVIEWS, '_min') : \app\models\Reviews::DEFAULT_FISH; ?>
                <img src="<?= $img_name ?>" alt="<?= Html::encode($model->comment) ?>">
            </span>
            <span class="review-date-name"><?= Html::encode($date_name) ?></span>
            <p class="review-text">
                <? if ($model->img_content): ?>
                    <? $max_img = UploadForm::getSrc($model->img_content, UploadForm::TYPE_REVIEWS, '_max'); ?>
                    <span class="review-photo">
                        <a class="gallery" rel="group" href="<?= $max_img ?>" title="<?= Html::encode($date_name) ?>">
                            <?= Html::img(UploadForm::getSrc($model->img_content, UploadForm::TYPE_REVIEWS), ['alt' => $date_name]) ?>
                        </a>
                        <i class="glyphicon glyphicon-zoom-in"></i>
                    </span>
                <? endif; ?>
                <?= nl2br(Html::encode($model->comment)) ?>
                <span class="clearfix"></span>
            </p>
        </li>
    <? endforeach; ?>
</ul>

<div class="text-center">
    <?= LinkPager::widget(['pagination' => $pagination]); ?>
</div>

<? if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success m-t-20 m-b-20"><?= Yii::$app->session->getFlash('success') ?></div>
    <?php $this->registerJs("$(document).scrollTop($('.layout').height())"); ?>
<? else: ?>
    <?
    $form = ActiveForm::begin([
        'enableClientValidation' => true,
        'enableAjaxValidation' => false,
        'enableClientScript' => true,
        'action' => Yii::$app->request->url . '#review-form',
        'options' => [
            'class' => 'form-horizontal',
            'name' => 'review-form',
            'id' => 'review-form',
        ],
        'fieldConfig' => [
            'template' => '<div class="col-xs-4 text-right">{label}</div><div class="col-xs-7">{input}{error}</div>'
        ],
    ]);
    $model = new \app\models\Reviews();
    $model->setScenario(\app\models\Reviews::SCENARIO_SITE);
    
    if (Yii::$app->user->id) {
        $profile = \app\models\Users::selfProfile();
        
        $model->name = $profile->name;
        $model->email = $profile->email;
    }

    if (Yii::$app->request->post('Reviews')) {
        $model->load(Yii::$app->request->post());
        if ($model->validate()) {
            $model->save(false);
            Yii::$app->session->setFlash('success', Yii::$app->vars->val(192));
            Yii::$app->response->redirect(Yii::$app->request->url);
            Yii::$app->end();
        }
    }
    ?>
    <div class="reviews-form">
        <?= $form->field($model, 'email')->textInput(['placeholder' => Yii::$app->vars->val(187)])->label(Yii::$app->vars->val(188)) ?>
        <?= $form->field($model, 'name')->label(Yii::$app->vars->val(189)) ?>
        <?= $form->field($model, 'comment')->textarea(['rows' => 6])->label(Yii::$app->vars->val(190)) ?>
        
        <div class="row m-t-20 m-b-20">
            <div class="col-xs-12 col-md-offset-4 col-md-8">
                <?= str_replace('{captcha}', '<div id="widget_ca_review"></div>',
                    $form->field($model, 'captcha', ['template' => '<div class="col-xs-12">{captcha}{error}</div>'])) ?>
            </div>
        </div>
        
        <div class="row">
            <div class="col-xs-offset-4 col-xs-7">
                <button class="btn btn-primary"><?= Yii::$app->vars->val(191) ?></button>
            </div>
        </div>
    </div>
    <? ActiveForm::end(); ?>
<? endif; ?>

<?php
$this->registerJs('
if ($(".gallery").length) {
    $(".gallery").colorbox({
        rel: "group",
        initWidth: 800,
        initHeight: 680,
        width: 800,
        height: 680,
        maxWidth: "80%",
        maxHeight: "90%",
        photo: true,

        current: "Фото {current} из {total}",
        previous: "Пред",
        next: "След",
        close: "Закрыть",
        imgError: "Фото не найдено"
    });
}
');