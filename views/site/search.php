<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\Pages;
use app\helpers\Normalize;
use app\models\Orders;
use app\models\Menu;
use yii\helpers\Url;
use app\helpers\Statuses;
use app\models\Faq;

$this->title = $model->title;
$this->params['meta_t'] = $model->meta_t;
$this->params['meta_d'] = $model->meta_d;
$this->params['meta_k'] = $model->meta_k;
$this->params['breadcrumbs'] = $model->getBreadcrumbs();
$this->params['banner_name'] = $model->banner_name;

$search = Yii::$app->request->get('q', '');
$section = 0;
?>
<div class="page-content">

    <? if (\app\models\Users::isManager()): ?>
        <a class="act-btn btn btn-info btn-sm" title="Редактировать" href="<?= Url::to(['admin/pages/edit','id' => $model->id]) ?>" target="_blank">
            <i class="glyphicon glyphicon-pencil"></i>
        </a>
    <? endif; ?>

    <? if ($model->menu_id): ?>

        <? $first_item = Menu::find()->sidebar($model->menu_id)->active()->one(); ?>
        <? $section = Yii::$app->request->get('section', $first_item->id); ?>

        <ul class="page-menu">
            <? foreach (Menu::find()->sidebar($model->menu_id)->active()->all() AS $menu_item): ?>

                <? $link = Url::to([Normalize::fixAlias(Pages::SEARCH_ID), 'q' => $search, 'section' => $menu_item->id]) ?>
                <? $active = ($section == $menu_item->id ? 'class="active"' : ''); ?>

                <li <?= $active ?>>
                    <a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a>
                </li>
            <? endforeach; ?>
        </ul>
    <? endif; ?>

    <div class="page-container <?= $model->menu_id ? '' : 'page-simple' ?>">
        <h1 class="page-title"><?= $model->title ?></h1>

        <?
        if (!empty($search)) {
            $q = explode(' ', $search);
            foreach ($q AS &$qv) {
                $q_tmp = preg_replace('/([а-яёй]+)$/ui', '', $qv);
                if (mb_strlen($q_tmp, Yii::$app->charset) <= 3) $q_tmp = $qv;
                $qv = $q_tmp;
            }

            switch ($section) {
                case 277:
                    $results = Pages::find()->where(['is_auto' => Statuses::STATUS_DISABLED])->andWhere(['like', 'CONCAT(title, meta_t, meta_d, meta_k)', $q])->orderBy(['title' => SORT_ASC])->all();
                    break;

                case 278:
                    $results = Faq::find()->where(['status' => Statuses::STATUS_ACTIVE])->andWhere(['like', 'CONCAT(question_text, answer_text)', $q])->orderBy('modified DESC')->all();
                    break;
            }
        }
        ?>

        <div class="search-results">
            <form action="<?= Url::to([Normalize::fixAlias(Pages::SEARCH_ID)]) ?>">
                <div class="input-group">
                    <span class="input-group-addon">Поисковая фраза:</span>
                    <input class="form-control" type="text" name="q" value="<?= Html::encode($search) ?>"/>
                </div>
                <input name="section" type="hidden" value="<?= $section ?>"/>
            </form>

            <? if (!empty($results)): ?>
                <p>Найдено записей: <strong><?= count($results) ?></strong></p>
                <div class="search-items">
                    <? foreach ($results AS $res): ?>
                        <? if ($section == 277): ?>
                            <a href="<?= Url::to([Normalize::fixAlias($res->alias)]) ?>" target="_blank"><?= $res->title ?><i class="glyphicon glyphicon-share-alt"></i></a>
                        <? else: ?>
                            <a href="<?= Url::to(['site/answer', 'id' => $res->id]) ?>" target="_blank"><?= nl2br(Html::encode($res->question_text)) ?><i class="glyphicon glyphicon-share-alt"></i></a>
                        <? endif; ?>
                    <? endforeach; ?>
                </div>
            <? elseif (empty($search)): ?>
                <div class="alert alert-info">Введите поисковый запрос.</div>
            <? else: ?>
                <div class="alert alert-info">Поиск по фразе "<strong><?= Html::encode($search) ?></strong>" не принес результата.<br/>Попробуйте изменить текст запроса для поиска.</div>
            <? endif; ?>
        </div>
    </div>
</div>