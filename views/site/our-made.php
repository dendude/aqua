<?php

use yii\helpers\Html;
use app\helpers\Normalize;
use app\models\Menu;
use yii\helpers\Url;

$this->title = $model->title;
$this->params['meta_t'] = $model->meta_t;
$this->params['meta_d'] = $model->meta_d;
$this->params['meta_k'] = $model->meta_k;
$this->params['breadcrumbs'] = $model->getBreadcrumbs();
$this->params['banner_name'] = $model->banner_name;
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
        <h1 class="page-title"><?= $model->title ?></h1>
        <h2 class="our-made-subtitle"><?= Yii::$app->vars->val(165) ?></h2>
        <h3 class="which-secret"><?= Yii::$app->vars->val(166) ?></h3>
        <div class="our-made">
            <a href="/img/our-made-icons/1.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(167) ?>"><i><?= Yii::$app->vars->val(167) ?></i></a>
            <a href="/img/our-made-icons/2.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(168) ?>"><i><?= Yii::$app->vars->val(168) ?></i></a>
            <a href="/img/our-made-icons/3.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(169) ?>"><i><?= Yii::$app->vars->val(169) ?></i></a>
            <a href="/img/our-made-icons/4.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(170) ?>"><i><?= Yii::$app->vars->val(170) ?></i></a>
            <a href="/img/our-made-icons/5.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(171) ?>"><i><?= Yii::$app->vars->val(171) ?></i></a>
            <a href="/img/our-made-icons/6.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(172) ?>"><i><?= Yii::$app->vars->val(172) ?></i></a>
            <a href="/img/our-made-icons/7.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(173) ?>"><i><?= Yii::$app->vars->val(173) ?></i></a>

            <a href="/img/our-made-icons/8.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(174) ?>"><i><?= Yii::$app->vars->val(174) ?></i></a>
            <a href="/img/our-made-icons/9.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(175) ?>"><i><?= Yii::$app->vars->val(175) ?></i></a>
            <a href="/img/our-made-icons/10.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(176) ?>"><i><?= Yii::$app->vars->val(176) ?></i></a>

            <a href="/img/our-made-icons/11.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(177) ?>"><i><?= Yii::$app->vars->val(177) ?></i></a>
            <a href="/img/our-made-icons/12.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(178) ?>"><i><?= Yii::$app->vars->val(178) ?></i></a>
            <a href="/img/our-made-icons/13.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(179) ?>"><i><?= Yii::$app->vars->val(179) ?></i></a>

            <a href="/img/our-made-icons/14.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(180) ?>"><i><?= Yii::$app->vars->val(180) ?></i></a>
            <a href="/img/our-made-icons/15.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(181) ?>"><i><?= Yii::$app->vars->val(181) ?></i></a>
            <a href="/img/our-made-icons/16.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(182) ?>"><i><?= Yii::$app->vars->val(182) ?></i></a>
            <a href="/img/our-made-icons/17.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(183) ?>"><i><?= Yii::$app->vars->val(183) ?></i></a>
            <a href="/img/our-made-icons/18.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(184) ?>"><i><?= Yii::$app->vars->val(184) ?></i></a>
            <a href="/img/our-made-icons/19.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(185) ?>"><i><?= Yii::$app->vars->val(185) ?></i></a>
            <a href="/img/our-made-icons/20.JPG" class="photo-slider" rel="slider" title="<?= Yii::$app->vars->val(186) ?>"><i><?= Yii::$app->vars->val(185) ?></i></a>
        </div>
    </div>
</div>
<?php
$this->registerJs("
$('.photo-slider').colorbox({
    width: 680,
    height: 420,
    rel: 'slider',
    current: 'Фото {current} из {total}',
});
");