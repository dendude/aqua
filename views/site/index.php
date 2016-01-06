<?php
use app\helpers\Statuses;
use app\models\forms\UploadForm;
use app\models\Pages;
use app\models\Faq;
use app\helpers\Normalize;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Photos;
use app\models\PhotoAlbums;

$this->title = $model->title;

$slider_photos = [];
$slider_items = Photos::find()
    ->where(['section_id' => PhotoAlbums::ALBUM_OUR_JOBS,
                 'status' => Statuses::STATUS_ACTIVE])
    ->orderBy(['ordering' => SORT_ASC])
    ->all();

if ($slider_items) {
    foreach ($slider_items AS $photo) {
        // если альбом скрыт - выбрасываем
        if ($photo->section->status != Statuses::STATUS_ACTIVE) break;

        $slider_photos[] = $photo;
    }
}

$this->registerJs("
    $('#sm_slider').smSlider({autoPlay : true, delay: 8000});
    $('#sm_slider2').smSlider({autoPlay : true, delay: 7000});
");

$faq = \app\models\Faq::find()
    ->where(['status' => Statuses::STATUS_ACTIVE])
    ->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC])
    ->limit(9)
    ->all();

$main_banners = \app\models\Photos::find()
->where(['section_id' => PhotoAlbums::ALBUM_MAIN_BANNERS,
             'status' => Statuses::STATUS_ACTIVE])
->orderBy('ordering ASC')
->all();

$photos_for_mark = Photos::find()->where(['section_id' => PhotoAlbums::ALBUM_OUR_JOBS])->all();
foreach ($photos_for_mark AS $photo) {
    $full_path = Yii::getAlias('@app') . '/web' . UploadForm::getSrc($photo->img_big, UploadForm::TYPE_GALLERY);
    $water_path = Yii::getAlias('@app') . '/web/img/watermark.png';

    $picture = new \app\components\Picture($full_path);
    $picture->watermark($water_path, 10, 10);
    $picture->imageout();

    echo $full_path;
    break;
}
?>
<div class="site-index">
    <? if ($main_banners && $main_banners[0]->section->status == Statuses::STATUS_ACTIVE): ?>
    <div class="index-banner">
        <div id="sm_slider2">
            <ul>
                <? foreach ($main_banners AS $bk => $banner): ?>
                <li>
                    <? if ($banner->page_id): ?><a href="<?= Url::to([Normalize::fixAlias($banner->page_id)]) ?>"><? endif; ?>
                        <img src="<?= UploadForm::getSrc($banner->img_big, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($this->title) ?>" width="1100" height="600" />
                    <? if ($banner->page_id): ?></a><? endif; ?>
                </li>
                <? endforeach; ?>
            </ul>
        </div>
    </div>
    <? endif; ?>
    <div class="index-content">
        <div class="index-infoblocks">
            <div class="infoblocks">
                <div class="infoblock-title"><?= Yii::$app->vars->val(81) ?></div>
                <div class="infoblock-content info-partners">
                    <a href="<?= Url::to([Normalize::fixAlias(199)]) ?>">
                        <img src="/img/partners.png" alt="" width="316" height="198"/>
                    </a>
                </div>
            </div>
            <div class="infoblocks infoblock-faq">
                <div class="infoblock-title"><?= Yii::$app->vars->val(82) ?></div>
                <div class="infoblock-content">
                <? if ($faq): ?>
                    <ul class="faq-list">
                    <? foreach ($faq AS $faq_item): ?>
                        <li>
                            <a href="<?= Url::to([Faq::ALIAS_PREFIX, 'id' => $faq_item->id]) ?>">
                                <span class="faq-item-question"><?= Html::encode($faq_item->question_text) ?></span>
                                <span class="faq-item-answer"><?= nl2br(Html::encode($faq_item->answer_text)) ?></span>
                            </a>
                        </li>
                    <? endforeach; ?>
                    </ul>
                    <a class="faq-add" data-target="#modal_form_<?= Faq::PAGE_ADD_ID ?>" data-toggle="modal">
                        <?= Yii::$app->vars->val(103) ?>
                    </a>
                    <!--<a class="faq-all" href="<?/*= Url::to([Normalize::fixAlias(Pages::aliasById(Faq::PAGE_ID))]) */?>"><?/*= Yii::$app->vars->val(101) */?></a>-->
                <? else: ?>
                    <p class="faq-empty"><?= Yii::$app->vars->val(102) ?></p>
                <? endif; ?>
                </div>
            </div>
        </div>
        <div class="index-text">
            <h1 class="line-title text-center"><?= Yii::$app->vars->val(83) ?></h1>
            <div class="index-ob">
                <div class="index-ob-cont">
                    <p class="index-ob-inside">
                        <?= Yii::$app->vars->val(84) ?>
                    </p>
                </div>
                <span class="index-ob-more"><?= Yii::$app->vars->val(157) ?></span>
            </div>

            <h2 class="why-us"><?= Yii::$app->vars->val(85) ?></h2>
            <div class="why-us-items">
                <a href="<?= Yii::$app->vars->val(145, false, true) ?>" title="<?= Yii::$app->vars->val(151, true) ?>" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(86) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(87) ?></span>
                    <span class="why-us-icons why-us-icon-1"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(146, false, true) ?>" title="<?= Yii::$app->vars->val(152, true) ?>" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(88) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(89) ?></span>
                    <span class="why-us-icons why-us-icon-2"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(147, false, true) ?>" title="<?= Yii::$app->vars->val(153, true) ?>" class="why-us-point mr0">
                    <span class="why-us-title"><?= Yii::$app->vars->val(90) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(91) ?></span>
                    <span class="why-us-icons why-us-icon-3"></span>
                </a>

                <a href="<?= Yii::$app->vars->val(148, false, true) ?>" title="<?= Yii::$app->vars->val(154, true) ?>" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(92) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(93) ?></span>
                    <span class="why-us-icons why-us-icon-4"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(149, false, true) ?>" title="<?= Yii::$app->vars->val(155, true) ?>" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(94) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(95) ?></span>
                    <span class="why-us-icons why-us-icon-5"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(150, false, true) ?>" title="<?= Yii::$app->vars->val(156, true) ?>" class="why-us-point mr0">
                    <span class="why-us-title"><?= Yii::$app->vars->val(96) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(97) ?></span>
                    <span class="why-us-icons why-us-icon-6"></span>
                </a>

                <div class="clearfix"></div>
            </div>
        </div>

        <? if (count($slider_photos)): ?>
        <? /*<h2 class="why-us"><?/*= Yii::$app->vars->val(98)</h2>*/ ?>
        <div class="index-our-job">
            <img src="<?= UploadForm::getSrc($slider_photos[0]->img_big, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($slider_photos[0]->title) ?>"/>
            <span class="our-jobs-default"><?= Yii::$app->vars->val(98) ?></span>
            <? /*if($slider_photos[0]->title || $slider_photos[0]->about): ?>
            <span class="our-job-title">
                <strong class="our-job-name"><?= Html::encode($slider_photos[0]->title) ?></strong>
                <span class="our-job-about"><?= nl2br(Html::encode($slider_photos[0]->about)) ?></span>
            </span>
            <? endif;*/ ?>
        </div>
        <div class="index-our-job-slider">
            <div id="sm_slider">
                <ul>
                    <? foreach ($slider_photos AS $pk => $photo_info): ?>
                        <? if ($pk%4 == 0): ?><li><? endif; ?>
                            <a onclick="set_job_img(this)" data-img="<?= UploadForm::getSrc($photo_info->img_big, UploadForm::TYPE_GALLERY) ?>">
                                <span>
                                    <img src="<?= UploadForm::getSrc($photo_info->img_small, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($photo_info->title) ?>"/>
                                </span>
                                <strong class="img-title"><?= Html::encode($photo_info->title) ?></strong>
                                <strong class="img-about hidden"><?= nl2br(Html::encode($photo_info->about)) ?></strong>
                            </a>
                        <? if ($pk%4 == 3): ?></li><? endif; ?>
                    <? endforeach; ?>
                    <? if (count($slider_photos) % 4 != 0): ?></li><? endif; ?>
                </ul>
            </div>
        </div>
        <div class="clearfix"></div>
        <? endif; ?>

        <div class="index-other-job">
            <h2 class="other-job-title"><?= Yii::$app->vars->val(99) ?></h2>
            <div class="other-job-items">
                <a href="<?= Yii::$app->vars->val(119) ?>" class="other-job-point other-job-1" title="<?= Yii::$app->vars->val(118,true) ?>" target="_blank">
                    <span class="other-job-subtitle"><?= Yii::$app->vars->val(114) ?></span>
                    <span class="other-job-text"><?= Yii::$app->vars->val(115) ?></span>
                    <span class="other-job-arrow">
                        <i class="glyphicons glyphicons-share"></i>
                    </span>
                </a>
                <a href="<?= Yii::$app->vars->val(120) ?>" class="other-job-point other-job-2" title="<?= Yii::$app->vars->val(118,true) ?>" target="_blank">
                    <span class="other-job-subtitle"><?= Yii::$app->vars->val(116) ?></span>
                    <span class="other-job-text"><?= Yii::$app->vars->val(117) ?></span>
                    <span class="other-job-arrow">
                        <i class="glyphicons glyphicons-share"></i>
                    </span>
                </a>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>
<?
$this->registerJs('
var $ob_cont = $(".index-ob-cont");
var $ob_inside = $(".index-ob-inside");

if ($ob_inside.height() > $ob_cont.height()) {
    $(".index-ob-more").css("display", "block").on("click", function(){
        $(this).remove();
        $ob_cont.animate({
            height: $ob_inside.height() + "px"
        });
    });
}
');