<?php
use app\models\Pages;
use yii\helpers\Url;
use yii\helpers\Html;
use app\models\Menu;
use app\helpers\Normalize;

$this->title = $model->title;
$this->params['meta_t'] = $model->meta_t;
$this->params['meta_d'] = $model->meta_d;
$this->params['meta_k'] = $model->meta_k;
$this->params['breadcrumbs'] = $model->getBreadcrumbs();
$this->params['banner_name'] = $model->banner_name;

$content = $model->getFixLinksContent();
preg_match('/{menu_(\d+)}/', $content, $matches);
if (isset($matches[1])) {
    $page_menu = Menu::find()->active()->sidebar($matches[1])->all();
    $content = str_replace($matches[0], '', $content);
}

$dom = new \app\components\simple_html_dom();
$dom->load($content);

if ($dom->find('.photo-slider')) {
    foreach ($dom->find('.photo-slider') AS $img) {
        $img->outertext = '<a class="photo-slider-link" rel="slider" href="' . $img->src . '" title="' . $img->alt . '">' . $img->outertext . '</a>';
    }
}

$content = $dom->outertext;

?>
<div class="page-content">

    <? if (\app\models\Users::isManager()): ?>
        <a class="act-btn btn btn-info btn-sm" title="Редактировать" href="<?= Url::to(['admin/pages/edit','id' => $model->id]) ?>" target="_blank">
            <i class="glyphicon glyphicon-pencil"></i>
        </a>
    <? endif; ?>

    <? if ($model->menu_id): ?>
        <ul class="page-menu">
            <? foreach (Menu::find()->sidebar($model->menu_id)->active()->all() AS $menu_item): ?>
                <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                <? $active = $menu_item->page_id == $model->id ? 'class="active"' : ''; ?>
                <li <?= $active ?>>
                    <a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a>
                    <? if ($menu_item->childs): ?>
                        <ul class="page-submenu">
                        <? foreach ($menu_item->childs AS $submenu_item): ?>
                            <? $sublink = $submenu_item->page ? Url::to([Normalize::fixAlias($submenu_item->page->alias)]) : '#'; ?>
                            <? $sub_active = $submenu_item->page_id == $model->id ? 'class="active"' : ''; ?>
                            <li <?= $sub_active ?>><a href="<?= $sublink ?>"><?= Html::encode($submenu_item->menu_name) ?></a></li>
                        <? endforeach; ?>
                        </ul>
                    <? endif; ?>
                </li>
            <? endforeach; ?>
        </ul>
    <? endif; ?>

    <div class="page-container <?= $model->menu_id ? '' : 'page-simple' ?>">
        <h1 class="page-title"><?= $this->title ?></h1>
        <div class="page-article">
            <?= $content ?>
            <? if ($model->is_shared): ?>
            <div class="clearfix"></div>
            <div class="share42init" data-title="<?= Html::encode($model->meta_t ? $model->meta_t : $this->title) ?>"
                                     data-description="<?= Html::encode($model->meta_d) ?>"
                                     data-image="<?= $model->getFirstImage() ?>"></div>
            <? endif; ?>
        </div>

        <? if ($model->id == Pages::REVIEWS_ID): ?>
            <?= \app\widgets\ReviewsList::widget(); ?>
        <? endif; ?>

        <? if (!empty($model->vcrumbs)): ?>
            <div class="v-crumbs">
                <div xmlns:v="http://rdf.data-vocabulary.org/#">
                <?
                $bn = 1;
                foreach($model->vcrumbs AS $page_id):
                $page_crumb = Pages::findOne($page_id);
                if ($page_crumb):
                ?>
                <span typeof="v:Breadcrumb">
                    <a href="<?= Url::to([\app\helpers\Normalize::fixAlias($page_crumb->alias)]) ?>" rel="v:url" property="v:title">
                        <?= $bn . '. ' . Html::encode($page_crumb->crumb) ?>
                    </a>
                </span>
                <? if($bn < count($model->vcrumbs)): ?>&nbsp;&nbsp;&raquo;&nbsp;&nbsp;<? endif; ?>
                <?
                endif;
                $bn++;
                endforeach;
                ?>
                </div>
            </div>
        <? endif; ?>
    </div>

    <div class="clearfix"></div>

</div>
<?
$this->registerJsFile('/lib/colorbox/jquery.colorbox.js', ['depends' => [\app\assets\AppAsset::className()]]);
$this->registerCssFile('/lib/colorbox/example3/colorbox.css');

$this->registerJs('
    $("#page_slider").smSlider({autoPlay : true, delay: 5000});

    if ($(".photo-slider-link").length) {
        $(".photo-slider-link").colorbox({
            height: 600,
            width: 800,
            maxHeight: "90%",
            maxWidth: "80%",
            rel: "slider"
        });
    }

    var sum_height = 0;
    $(".page-menu>li").each(function(){
        sum_height += (+$(this).outerHeight());
    });

    if ($(".page-content").height() < sum_height) {
        setTimeout(function(){
            $(".page-content").height(sum_height + "px");
        }, 500);
    }

    if ($(".aqua-slider").length) {
        $(".aqua-slider").colorbox({
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

    var si = 0;
    var $fish_list = $(".fish-list-menu");
    if ($fish_list.length) {
        var pos = $fish_list.offset().top;
        var wid = $fish_list.outerWidth();
        var set = false;

        $(document).on("scroll", function(){
            if ($(this).scrollTop() >= (pos - 10)) {
                if (!set) {
                    $fish_list.addClass("fixed").css("width", wid);
                    $("<div style=\"height:42px;\"></div>").insertAfter($fish_list);
                    set = true;
                }
            } else {
                if (set) {
                    $fish_list.removeClass("fixed");
                    $fish_list.next().remove();
                    set = false;
                }
            }
        });
        $(document).scroll();
    }

    if ($("a[href^=#]").length) {
        $("a[href^=#]").on("click", function(e){
            var anchor_id = $(this).attr("href").replace("#", "");

            if ($("#" + anchor_id).length) {
                var ot = $("#" + anchor_id).offset().top;
                $("html,body").stop().animate({
                    scrollTop: (ot - 30) + "px"
                }, 1000);
            }
        });

        // переход при обновлении страницы с якорем
        var hash = location.hash.replace("#","");
        if (hash != "" && $("a[href=#" + hash + "]").length) {
            setTimeout(function(){
                $("a[href=#" + hash + "]").click();
            },1000);
        }
    }
');