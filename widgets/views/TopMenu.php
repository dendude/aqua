<?
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Normalize;

?>
<ul class="top-menu">
    <li class="logo-link"><?= Html::a('', Yii::$app->homeUrl) ?></li>
    <? foreach ($menu AS $menu_item): ?>
        <? if ($menu_item->parent->status == \app\helpers\Statuses::STATUS_ACTIVE): ?>
        <? $active = $menu_item->page && Yii::$app->request->url == Url::to([Normalize::fixAlias($menu_item->page->alias)]) ? 'class="active"' : ''; ?>
        <li <?= $active ?>>
            <span class="corona"></span>
            <?= Html::a($menu_item->menu_name, $menu_item->page ? Normalize::fixAlias($menu_item->page->alias, true) : '#') ?>
            <? if ($menu_item->childs): ?>
            <ul class="top-submenu">
                <? foreach ($menu_item->childs AS $child_item): ?>
                <li>
                    <?= Html::a($child_item->menu_name, $child_item->page ? Normalize::fixAlias($child_item->page->alias, true) : '#') ?>
                </li>
                <? endforeach; ?>
            </ul>
            <? endif; ?>
        </li>
        <? endif; ?>
    <? endforeach; ?>
</ul>