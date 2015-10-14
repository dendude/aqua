<?
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Normalize;
?>
<ul class="sidebar-menu">
    <? foreach ($menu AS $menu_item): ?>
        <? if ($menu_item->parent->status == \app\helpers\Statuses::STATUS_ACTIVE): ?>
        <? $active = $menu_item->page && Yii::$app->request->url == Url::to([Normalize::fixAlias($menu_item->page->alias)]) ? 'class="active"' : ''; ?>
        <li <?= $active ?>>
            <?= Html::a($menu_item->menu_name, $menu_item->page ? [Normalize::fixAlias($menu_item->page->alias)] : '#') ?>
            <? if ($menu_item->childs): ?>
            <div class="sidebar-submenu">
                <ul>
                    <? foreach ($menu_item->childs AS $child_item): ?>
                    <li>
                        <?= Html::a($child_item->menu_name, $child_item->page ? [Normalize::fixAlias($child_item->page->alias)] : '#') ?>
                    </li>
                    <? endforeach; ?>
                </ul>
            </div>
            <? endif; ?>
        </li>
        <? endif; ?>
    <? endforeach; ?>
</ul>