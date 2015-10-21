<?php
use app\helpers\Statuses;
use app\models\forms\UploadForm;
use yii\helpers\Html;

$this->title = 'Альфаро';

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
                <div class="infoblock-title"><?= Yii::$app->vars->val(82) ?></div>
                <div class="infoblock-content"></div>
            </div>
        </div>
        <div class="index-text">
            <h1 class="line-title text-center"><?= Yii::$app->vars->val(83) ?></h1>
            <p><?= Yii::$app->vars->val(84) ?></p>
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

        <div class="index-our-job">
            <span class="our-job-title"><?= Yii::$app->vars->val(98) ?></span>
        </div>

        <? if (count($slider_photos)): ?>
        <div class="index-our-job-slider">
            <div id="sm_slider">
                <ul>
                    <? foreach ($slider_photos AS $pk => $photo_info): ?>
                        <? if ($pk%4 == 0): ?><li><? endif; ?>
                            <a href="#" title="">
                                <span>
                                    <img src="<?= UploadForm::getSrc($photo_info->img_small, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($photo_info->title) ?>"/>
                                </span>
                                <? if ($photo_info->title || $photo_info->about): ?>
                                    <i><strong><?= Html::encode($photo_info->title) ?></strong><em><?= nl2br(Html::encode($photo_info->about)) ?></em></i>
                                <? endif; ?>
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