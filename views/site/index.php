<?php
use app\helpers\Statuses;
use app\models\forms\UploadForm;
use yii\helpers\Html;

$this->title = $model->title;

$slider_photos = [];
$slider_albums = \app\models\PhotoAlbums::find()
    ->where(['status' => Statuses::STATUS_ACTIVE])
    ->orderBy(['ordering' => SORT_ASC])
    ->all();

if ($slider_albums) {
    foreach ($slider_albums AS $s_album) {
        if ($s_album->photos) {
            foreach ($s_album->photos AS $photo) {
                if ($photo->status == Statuses::STATUS_ACTIVE) $slider_photos[] = $photo;
            }
        }
    }
}

$this->registerJs("
    $('#sm_slider').smSlider({autoPlay : true, delay: 8000});
");

$faq = \app\models\Faq::find()
    ->where(['status' => Statuses::STATUS_ACTIVE])
    ->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC])
    ->limit(9)
    ->all();
?>
<div class="site-index">
    <div class="index-banner">
        <img lowsrc="/img/banner_low.jpg" src="/img/banner.jpg" alt="" width="1100" />
    </div>
    <div class="index-content">
        <div class="index-infoblocks">
            <div class="infoblocks">
                <div class="infoblock-title"><?= Yii::$app->vars->val(81) ?></div>
                <div class="infoblock-content info-partners">
                    <img src="/img/partners.png" alt="" width="316" height="198"/>
                </div>
            </div>
            <div class="infoblocks infoblock-faq">
                <div class="infoblock-title">
                    <a class="faq-add" href=""><?= Yii::$app->vars->val(103) ?></a>
                    <?= Yii::$app->vars->val(82) ?>
                </div>
                <div class="infoblock-content">
                <? if ($faq): ?>
                    <ul class="faq-list">
                    <? foreach ($faq AS $faq_item): ?>
                        <li>
                            <a href="">
                                <span class="faq-item-question"><?= Html::encode($faq_item->question_text) ?></span>
                                <span class="faq-item-answer"><?= nl2br(Html::encode($faq_item->answer_text)) ?></span>
                            </a>
                        </li>
                    <? endforeach; ?>
                    </ul>
                    <a class="faq-all" href=""><?= Yii::$app->vars->val(101) ?></a>
                <? else: ?>
                    <p class="faq-empty"><?= Yii::$app->vars->val(102) ?></p>
                <? endif; ?>
                </div>
            </div>
        </div>
        <div class="index-text">
            <h1 class="line-title text-center"><?= Yii::$app->vars->val(83) ?></h1>
            <p class="index-ob"><?= Yii::$app->vars->val(84) ?></p>
            <h2 class="why-us"><?= Yii::$app->vars->val(85) ?></h2>
            <div class="why-us-items">
                <div class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(86) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(87) ?></span>
                    <div class="why-us-icons why-us-icon-1"></div>
                </div>
                <div class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(88) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(89) ?></span>
                    <div class="why-us-icons why-us-icon-2"></div>
                </div>
                <div class="why-us-point mr0">
                    <span class="why-us-title"><?= Yii::$app->vars->val(90) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(91) ?></span>
                    <div class="why-us-icons why-us-icon-3"></div>
                </div>

                <div class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(92) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(93) ?></span>
                    <div class="why-us-icons why-us-icon-4"></div>
                </div>
                <div class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(94) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(95) ?></span>
                    <div class="why-us-icons why-us-icon-5"></div>
                </div>
                <div class="why-us-point mr0">
                    <span class="why-us-title"><?= Yii::$app->vars->val(96) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(97) ?></span>
                    <div class="why-us-icons why-us-icon-6"></div>
                </div>

                <div class="clearfix"></div>
            </div>
        </div>

        <? if (count($slider_photos)): ?>
        <h2 class="why-us"><?= Yii::$app->vars->val(98) ?></h2>
        <div class="index-our-job">
            <img src="<?= UploadForm::getSrc($slider_photos[0]->img_big, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($slider_photos[0]->title) ?>"/>
            <? if($slider_photos[0]->title || $slider_photos[0]->about): ?>
            <span class="our-job-title">
                <strong class="our-job-name"><?= Html::encode($slider_photos[0]->title) ?></strong>
                <span class="our-job-about"><?= nl2br(Html::encode($slider_photos[0]->about)) ?></span>
            </span>
            <? endif; ?>
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
                <div class="other-job-point other-job-1">
                    <span class="other-job-subtitle">Горки, водопады</span>
                    <span class="other-job-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquam aperiam beatae doloribus dolorum, excepturi, fuga fugit ipsum, iure laudantium non nostrum officia perspiciatis porro quo quod quos sint velit? Doloremque!</span>
                </div>
                <div class="other-job-point other-job-2">
                    <span class="other-job-subtitle">Ландшафтный дизайн</span>
                    <span class="other-job-text">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab amet animi aspernatur consequuntur cumque deleniti eaque est eveniet fugit inventore minus, neque, nobis officiis praesentium similique ullam voluptatem? Beatae, porro?</span>
                </div>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>