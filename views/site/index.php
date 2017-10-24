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

/**
 * @var $this \yii\web\View
 * @var $model Pages
 * @var $videoSlider \app\models\Videos[]
 */

$this->title = $model->title;
$this->params['meta_t'] = $model->meta_t;
$this->params['meta_d'] = $model->meta_d;
$this->params['meta_k'] = $model->meta_k;

$videoSlider = \app\models\Videos::find()->active()->ordering()->all();

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
    $('.sm_slider').smSlider({autoPlay : true, delay: 8000});
    $('#sm_slider2').smSlider({autoPlay : true, delay: 7000});
    $('#sm_slider3').smSlider({autoPlay : true, delay: 10000});
");

$faq = \app\models\Faq::find()
    ->where(['status' => Statuses::STATUS_ACTIVE])
    ->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC])
    ->limit(3)
    ->all();

$main_banners = \app\models\Photos::find()
->where(['section_id' => PhotoAlbums::ALBUM_MAIN_BANNERS,
             'status' => Statuses::STATUS_ACTIVE])
->orderBy('ordering ASC')
->all();
?>
<div class="site-index">
    <? if ($main_banners && $main_banners[0]->section->status == Statuses::STATUS_ACTIVE): ?>
    <div class="index-banner">
        <div id="sm_slider2">
            <ul>
                <? foreach ($main_banners AS $bk => $banner): ?>
                <li>
                    <? if ($banner->page_id): ?><a href="<?= Url::to([Normalize::fixAlias($banner->page_id)]) ?>"><? endif; ?>
                        <img src="<?= UploadForm::getSrc($banner->img_big, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($banner->about) ?>" width="1100" height="600" />
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
                <? endif; ?>
                </div>
            </div>
    
            <div class="infoblocks infoblock-articles">
                <div class="infoblock-title"><?= Yii::$app->vars->val(193) ?></div>
                <div class="infoblock-content">
                    <?
                        /** @var $last_page Pages */
                        /** @var $main_page Pages */
                        
                        // последняя статья для публикации первой в блоке
                        $last_page = Pages::find()->where(['is_first_article' => Statuses::STATUS_ACTIVE])->orderBy(['created' => SORT_DESC])->one();
                        if ($last_page) {
                            $dom = new \app\components\simple_html_dom();
                            $dom->load($last_page->content);
    
                            if (count($dom->find('p'))) {
                                $last_text = mb_substr($dom->find('p', 0)->plaintext, 0, 120, Yii::$app->charset);
                            } else {
                                $last_text = mb_substr($dom->plaintext, 0, 120, Yii::$app->charset);
                            }
                            $last_src = count($dom->find('img')) ? $dom->find('img', 0)->src : '/img/default-fish.png';
                        }
                    
                        // статья для ручной публикации второй по порядку в блоке
                        $main_page = Pages::find()->where(['is_article' => Statuses::STATUS_ACTIVE])->one();
                        if ($main_page) {
                            $dom = new \app\components\simple_html_dom();
                            $dom->load($main_page->content);
                            
                            if (count($dom->find('p'))) {
                                $main_text = mb_substr($dom->find('p', 0)->plaintext, 0, 120, Yii::$app->charset);
                            } else {
                                $main_text = mb_substr($dom->plaintext, 0, 120, Yii::$app->charset);
                            }
                            $main_src = count($dom->find('img')) ? $dom->find('img', 0)->src : '/img/default-fish.png';
                        }
                    ?>
                    <ul class="faq-list">
                        <? if ($last_page && isset($last_text) && isset($last_src)): ?>
                            <li>
                                <a class="faq-item-image" href="<?= Url::to([Normalize::fixAlias($last_page->id)]) ?>" title="<?= Html::encode($last_page->title) ?>">
                                    <img src="<?= $last_src ?>" alt="<?= Html::encode($last_page->title) ?>" />
                                </a>
                                <a class="faq-item-link" href="<?= Url::to([Normalize::fixAlias($last_page->id)]) ?>">
                                    <span class="faq-item-date"><?= Normalize::getDateByTime($last_page->created) ?></span>
                                    <span class="faq-item-question"><?= Html::encode($last_page->title) ?></span>
                                    <span class="faq-item-answer"><?= $last_text ?>...</span>
                                </a>
                            </li>
                        <? endif; ?>
                        <? if ($main_page && isset($main_text) && isset($main_src)): ?>
                            <li>
                                <a class="faq-item-image" href="<?= Url::to([Normalize::fixAlias($main_page->id)]) ?>" title="<?= Html::encode($main_page->title) ?>">
                                    <img src="<?= $main_src ?>" alt="<?= Html::encode($main_page->title) ?>" />
                                </a>
                                <a class="faq-item-link" href="<?= Url::to([Normalize::fixAlias($main_page->id)]) ?>">
                                    <span class="faq-item-question"><?= Html::encode($main_page->title) ?></span>
                                    <span class="faq-item-answer"><?= $main_text ?>...</span>
                                </a>
                            </li>
                        <? endif; ?>
                    </ul>
                    <a class="faq-add" href="<?= Url::to([Normalize::fixAlias(227)]) ?>"><?= Yii::$app->vars->val(194) ?></a>
                </div>
            </div>
        </div>
        <div class="index-text">
            <h1 class="line-title text-center"><?= Yii::$app->vars->val(83) ?></h1>
            <div class="index-ob">
                <div class="index-ob-cont">
                    <p class="index-ob-inside"><?= Yii::$app->vars->val(84) ?></p>
                </div>
                <span class="index-ob-more"><?= Yii::$app->vars->val(157) ?></span>
            </div>

            <h2 class="why-us"><?= Yii::$app->vars->val(85) ?></h2>
            <div class="why-us-items">
                <a href="<?= Yii::$app->vars->val(145, false, true) ?>" title="<?= Yii::$app->vars->val(151, true) ?>" target="_blank" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(86) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(87) ?></span>
                    <span class="why-us-icons why-us-icon-1"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(146, false, true) ?>" title="<?= Yii::$app->vars->val(152, true) ?>" target="_blank" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(88) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(89) ?></span>
                    <span class="why-us-icons why-us-icon-2"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(147, false, true) ?>" title="<?= Yii::$app->vars->val(153, true) ?>" target="_blank" class="why-us-point mr0">
                    <span class="why-us-title"><?= Yii::$app->vars->val(90) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(91) ?></span>
                    <span class="why-us-icons why-us-icon-3"></span>
                </a>

                <a href="<?= Yii::$app->vars->val(148, false, true) ?>" title="<?= Yii::$app->vars->val(154, true) ?>" target="_blank" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(92) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(93) ?></span>
                    <span class="why-us-icons why-us-icon-4"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(149, false, true) ?>" title="<?= Yii::$app->vars->val(155, true) ?>" target="_blank" class="why-us-point">
                    <span class="why-us-title"><?= Yii::$app->vars->val(94) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(95) ?></span>
                    <span class="why-us-icons why-us-icon-5"></span>
                </a>
                <a href="<?= Yii::$app->vars->val(150, false, true) ?>" title="<?= Yii::$app->vars->val(156, true) ?>" target="_blank" class="why-us-point mr0">
                    <span class="why-us-title"><?= Yii::$app->vars->val(96) ?></span>
                    <span class="why-us-text"><?= Yii::$app->vars->val(97) ?></span>
                    <span class="why-us-icons why-us-icon-6"></span>
                </a>

                <div class="clearfix"></div>
            </div>
        </div>

        <? if (count($slider_photos)): ?>
            <div class="index-our-job">
                <img src="<?= UploadForm::getSrc($slider_photos[0]->img_big, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($slider_photos[0]->title) ?>"/>
                <span class="our-jobs-default"><?= Yii::$app->vars->val(98) ?></span>
            </div>
            <div class="index-our-job-slider">
                <div class="hidden-xs">
                    <div class="sm_slider">
                        <ul>
                            <? foreach ($slider_photos AS $pk => $photo_info): ?>
                                <? if ($pk%4 == 0): ?><li><? endif; ?>
                                    <a onclick="set_job_img(this)" data-img="<?= UploadForm::getSrc($photo_info->img_big, UploadForm::TYPE_GALLERY) ?>">
                                        <span>
                                            <img src="<?= UploadForm::getSrc($photo_info->img_small, UploadForm::TYPE_GALLERY) ?>" alt="<?= Html::encode($photo_info->about) ?>"/>
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
                <div class="hidden visible-xs">
                    <div class="sm_slider">
                        <ul>
                        <? foreach ($slider_photos AS $pk => $photo_info): ?>
                            <li>
                                <a onclick="set_job_img(this)" data-img="<?= UploadForm::getSrc($photo_info->img_big, UploadForm::TYPE_GALLERY) ?>">
                                    <span>
                                        <img src="<?= UploadForm::getSrc($photo_info->img_small, UploadForm::TYPE_GALLERY) ?>"
                                             alt="<?= Html::encode($photo_info->about) ?>"/>
                                    </span>
                                    <strong class="img-title"><?= Html::encode($photo_info->title) ?></strong>
                                    <strong class="img-about hidden"><?= nl2br(Html::encode($photo_info->about)) ?></strong>
                                </a>
                            </li>
                            <? endforeach; ?>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="clearfix"></div>
        <? endif; ?>
    
        <? if (!empty($videoSlider)): ?>
            <h3 class="index-video-title">Наши видеозаписи</h3>
            <div class="index-video-slider">
                <div id="sm_slider3">
                    <ul>
                        <? $vk = 0; ?>
                        <? foreach ($videoSlider AS $vk => $vm): ?>
                            <? if ($vk++ == 0): ?><li><? endif; ?>
                                <span class="video-preview">
                                    <? preg_match('/^http\:\/\/img\.youtube\.com\/vi\/(\w+)\/0\.jpg/i', $vm->preview_url, $matches); ?>
                                    <a href="<?= $matches[1] ?>" title="Смотреть: <?= Html::encode($vm->title) ?>" class="colorbox-video">
                                        <img src="<?= $vm->preview_url ?>" alt="<?= Html::encode($vm->title) ?>"/>
                                    </a>
                                    <span class="video-about"><?= nl2br(Html::encode($vm->about)) ?></span>
                                </span>
                            <? if ($vk % 2 == 0): ?></li><? endif; ?>
                        <? endforeach; ?>
                        <? if ($vk % 3 != 2): ?></li><? endif; ?>
                    </ul>
                </div>
            </div>
            <? $this->registerJs("
                $('.colorbox-video').colorbox({innerWidth: 560, innerHeight: 315, scrolling: false, html: function(){
                    return \"<iframe width='560' height='315' src='https://www.youtube.com/embed/\" + $(this).attr('href') + \"' frameborder='0' allowfullscreen></iframe>\";
                }});
            "); ?>
        <? endif; ?>
        
        <div class="hidden-xs">
            <div class="other-job-articles m-b-none"><?= Yii::$app->vars->val(158) ?></div>
        </div>

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
    
        <div class="hidden-xs">
            <div class="other-job-articles m-t-none"><?= Yii::$app->vars->val(159) ?></div>
        </div>
    </div>
</div>
<?
$this->registerJs('
var $ob_cont = $(".index-ob-cont");
var $ob_inside = $(".index-ob-inside");

if ($ob_inside.outerHeight() > $ob_cont.height()) {
    $(".index-ob-more").css("display", "block").on("click", function(){
        $(this).remove();
        $ob_cont.animate({
            height: $ob_inside.height() + "px"
        });
    });
}
');



