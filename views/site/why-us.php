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
</div>