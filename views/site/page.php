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

$content = $model->getFixLinksContent();
$content = str_replace('<table>', '<table class="table table-bordered table-striped table-condensed">', $content);

preg_match('/{menu_(\d+)}/', $content, $matches);
if (isset($matches[1])) {
    $page_menu = Menu::find()->active()->sidebar($matches[1])->all();
    $content = str_replace($matches[0], '', $content);
}

?>
<div class="page-content">

    <? if (\app\models\Users::isManager()): ?>
        <a class="btn btn-info btn-sm pull-right" title="Редактировать" href="<?= Url::to(['admin/pages/edit','id' => $model->id]) ?>" target="_blank">
            <i class="glyphicon glyphicon-pencil"></i>
        </a>
    <? endif; ?>

    <? if (!empty($page_menu)): ?>
        <ul class="page-menu">
            <? foreach ($page_menu AS $menu_item): ?>
                <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                <li><a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a></li>
            <? endforeach; ?>
        </ul>
    <? endif; ?>

    <div class="page-container <?= empty($page_menu) ? 'page-simple' : '' ?>">
        <h1 class="page-title"><?= $this->title ?></h1>
        <div class="page-article">
            <?= $content ?>
            <? if ($model->is_shared): ?>
            <div class="share42init" data-title="<?= Html::encode($model->meta_t ? $model->meta_t : $this->title) ?>"
                                     data-description="<?= Html::encode($model->meta_d) ?>"
                                     data-image="<?= $model->getFirstImage() ?>"></div>
            <? endif; ?>
        </div>

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