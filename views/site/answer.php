<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Normalize;
use app\models\Faq;
use app\models\Pages;

$faq_page = Pages::findOne(Faq::PAGE_ID);
$show_length = 50;

$this->title = mb_substr(Html::encode($model->question_text), 0, $show_length, Yii::$app->charset);

if (mb_strlen($model->question_text, Yii::$app->charset) > $show_length) {
    // сохращаем вопрос для хлебных крошек
    $this->title .= '...';
}

// вопросы и ответы
$this->params['breadcrumbs'][] = ['url' => Url::to([Normalize::fixAlias($faq_page->alias)]),
                                'label' => $faq_page->crumb];

// раздел
$this->params['breadcrumbs'][] = ['url' => Url::to(['site/page', 'alias' => $faq_page->alias, 'id' => $model->section_id]),
                                'label' => $model->section->name];

// вопрос
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="page-container page-simple">
        <h1 class="page-title"><?= Html::encode($model->question_text) ?></h1>
        <p class="faq-author">Автор: <?= nl2br(Html::encode($model->name)) ?></p>
        <hr/>
        <p class="faq-question">
            <div><strong>Ответ</strong></div>
            <?= nl2br(Html::encode($model->answer_text)) ?>
        </p>
        <hr/>
        <p class="faq-created"><?= Normalize::getDateByTime($model->created) ?></p>
    </div>
</div>