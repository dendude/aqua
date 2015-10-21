<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Menu;
use yii\helpers\Url;
use app\helpers\Normalize;
use app\models\Pages;

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
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="layout">
        <nav class="top-nav">
            <div class="top-container">
                <form class="top-search" action="<?= Url::to([Normalize::fixAlias(Pages::aliasById(Pages::SEARCH_ID))]) ?>">
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
                            <? if (($mk+1) < count($top_menu1)): ?><li>|</li><? endif; ?>
                        <? endforeach; ?>
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
                <? foreach ($top_menu2 AS $mk => $menu_item): ?>
                    <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                    <a class="top-acts" href="<?= $link ?>">
                        <?= $menu_item->menu_name ?>
                        <i></i>
                    </a>
                <? endforeach; ?>
            <? endif; ?>
            </div>
        </div>

        <nav class="navbar-main">
            <table>
                <tr>
                <? if ($top_menu3): ?>
                    <? foreach ($top_menu3 AS $mk => $menu_item): ?>
                        <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                        <td>
                            <a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a>
                        </td>
                    <? endforeach; ?>
                <? endif; ?>
                </tr>
            </table>
        </nav>

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
        <div class="footer-container">
            <?= Yii::$app->vars->val(80) ?>
        </div>
    </footer>

    <?php $this->endBody() ?>

    <div class="layout-gradient"></div>
    </body>
    </html>
<?php $this->endPage() ?>