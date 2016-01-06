<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Menu;
use yii\helpers\Url;
use app\helpers\Normalize;
use app\models\Pages;
use \app\models\Users;

AppAsset::register($this);

$top_menu1 = Menu::find()->active()->top1()->all();
$top_menu2 = Menu::find()->active()->top2()->all();
$top_menu3 = Menu::find()->active()->top3()->all();

$footer_menu = Menu::find()->active()->footer()->all();

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>

        <link href="/favicon.ico?2" rel="shortcut icon" type="image/x-icon"/>

        <title><?= Html::encode(!empty($this->params['meta_t']) ? $this->params['meta_t'] : $this->title) ?></title>
        <? if (!empty($this->params['meta_d'])): ?><meta name="description" content="<?= Html::encode($this->params['meta_d']) ?>"/><? endif; ?>
        <? if (!empty($this->params['meta_k'])): ?><meta name="keywords" content="<?= Html::encode($this->params['meta_k']) ?>"/><? endif; ?>

        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="layout">
        <nav class="top-nav">
            <div class="top-container">
                <form class="top-search" action="<?= Url::to([Normalize::fixAlias(Pages::SEARCH_ID)]) ?>">
                    <div class="input-search">
                        <input name="q" type="text" placeholder="<?= Yii::$app->vars->val(78, true) ?>" value="<?= Yii::$app->request->get('q','') ?>" />
                    </div>
                    <button>
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </form>
                <div class="top-info">
                    <span class="top-contacts">
                        <?= Yii::$app->vars->val(1) ?><br/>
                        <small><?= Yii::$app->vars->val(2) ?></small>
                    </span>
                    <? if ($top_menu1): ?>
                    <ul class="top-menu">
                        <? foreach ($top_menu1 AS $mk => $menu_item): ?>
                            <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                            <li><a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a></li>
                            <? if (($mk+1) < count($top_menu1) || Users::isManager()): ?><li>|</li><? endif; ?>
                        <? endforeach; ?>
                        <? if (Users::isAdmin()): ?>
                            <li><a href="<?= Url::to(['admin/pages/list']) ?>">Admin</a></li>
                        <? elseif (Users::isManager()): ?>
                            <li><a href="<?= Url::to(['admin/pages/list']) ?>">Manager</a></li>
                        <? endif; ?>
                    </ul>
                    <? endif; ?>
                </div>
            </div>
        </nav>

        <div class="top-actions">
            <div class="top-logo">
                <a href="<?= Yii::$app->homeUrl ?>">&nbsp;</a>
            </div>
            <div class="top-words">
                <div class="cell"><?= Yii::$app->vars->val(79) ?></div>
            </div>
            <div class="top-buttons">
            <? if ($top_menu2): ?>
                <? foreach ($top_menu2 AS $menu_item): ?>
                    <a class="top-acts top-act-<?= $menu_item->id ?>" data-target="#modal_form_<?= $menu_item->id ?>" data-toggle="modal">
                        <?= $menu_item->menu_name ?>
                        <i></i>
                    </a>
                <? endforeach; ?>
            <? endif; ?>
            </div>
        </div>

        <nav class="navbar-main <? if (!in_array(Yii::$app->request->url, ['/', '/index' . Yii::$app->urlManager->suffix], true)): ?>navbar-simple<? endif; ?>">
            <ul>
            <? if ($top_menu3): ?>
                <? foreach ($top_menu3 AS $menu_item): ?>
                    <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                    <li>
                        <a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a>
                        <? if ($menu_item->childs): ?>
                            <ul>
                            <? foreach ($menu_item->childs AS $submenu_item): ?>
                                <? if ($submenu_item->status != \app\helpers\Statuses::STATUS_ACTIVE) continue; ?>
                                <? $link = $submenu_item->page ? Url::to([Normalize::fixAlias($submenu_item->page->alias)]) : '#'; ?>
                                <li>
                                    <a href="<?= $link ?>"><?= Html::encode($submenu_item->menu_name) ?></a>
                                </li>
                            <? endforeach; ?>
                            </ul>
                        <? endif; ?>
                    </li>
                <? endforeach; ?>
            <? endif; ?>
            </ul>
        </nav>

        <? if (!empty($this->params['banner_name'])): ?>
            <? $banner_model = \app\models\Photos::find()->where(['img_big' => $this->params['banner_name']])->one() ?>
            <div class="top-banner">
                <span class="top-banner-inner">
                    <? if (!empty($banner_model->page_id)): ?><a href="<?= Url::to([Normalize::fixAlias($banner_model->page_id)]) ?>"><? endif; ?>
                        <?= Html::img(\app\models\forms\UploadForm::getSrc($this->params['banner_name'], \app\models\forms\UploadForm::TYPE_GALLERY), ['alt' => $banner_model->title]) ?>
                    <? if (!empty($banner_model->page_id)): ?></a><? endif; ?>
                </span>
            </div>
        <? endif; ?>

        <div class="main-container">
            <?= Breadcrumbs::widget([
                'homeLink' => ['url' => Yii::$app->homeUrl, 'label' => Yii::$app->vars->val(100)],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <? if ($footer_menu): ?>
            <ul class="footer-menu">
                <? foreach ($footer_menu AS $mk => $menu_item): ?>
                    <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                    <li><a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a></li>
                    <? if (($mk+1) < count($footer_menu)): ?><li>|</li><? endif; ?>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
        <div class="footer-container"><?= Yii::$app->vars->val(80) ?></div>
    </footer>

    <noindex>
        <div class="layout-gradient"></div>
        <?= \app\widgets\ModalForms::widget(); ?>
    </noindex>

    <?php $this->endBody() ?>

    <input type="hidden" id="page_order_aqua" value="<?= Url::to([Normalize::fixAlias(Pages::ORDER_ID_AQUA)]) ?>" />
    <input type="hidden" id="page_order_services" value="<?= Url::to([Normalize::fixAlias(Pages::ORDER_ID_SERVICES)]) ?>" />

    </body>
    </html>
<?php $this->endPage() ?>