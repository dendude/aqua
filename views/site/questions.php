<?php

use app\models\Faq;
use app\models\FaqSections;
use app\helpers\Statuses;
use app\models\Pages;
use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Normalize;

$query = FaqSections::find()
    ->where(['status' => Statuses::STATUS_ACTIVE])
    ->orderBy(['ordering' => SORT_ASC]);

// если выбран раздел
if (!empty($section_id)) {
    $check_section = FaqSections::findOne($section_id);
    if ($check_section) {
        $query->andWhere(['id' => $section_id]);
    }
}

$sections = $query->all();

$this->title = $model->title;

if (!empty($check_section)) {
    $this->params['breadcrumbs'][] = ['url' => Url::to(['site/page', 'alias' => Pages::aliasById(Faq::PAGE_ID)]),
                                    'label' => $this->title];
    $this->params['breadcrumbs'][] = $check_section->name;
} else {
    $this->params['breadcrumbs'][] = $this->title;
}

?>
<div class="page-content">
    <div class="page-container page-simple">
        <h1 class="page-title"><?= $this->title ?></h1>
        <? if ($sections): ?>

            <? foreach ($sections AS $section): ?>
            <ul class="faq-section">
                <? if (count($section->questions) == 0) continue; ?>
                <li>
                    <a href="<?= Url::to(['site/page', 'alias' => Pages::aliasById(Faq::PAGE_ID), 'id' => $section->id]) ?>">
                        <?= Html::encode($section->name) ?>
                    </a>
                    <ul class="faq-questions">
                        <? foreach ($section->questions AS $question): ?>
                            <? if ($question->status != Statuses::STATUS_ACTIVE) continue; ?>
                            <li>
                                <a href="<?= Url::to([Faq::ALIAS_PREFIX, 'id' => $question->id]) ?>" onclick="show_answer(this, event)">
                                    <?= nl2br(Html::encode($question->question_text)) ?>
                                </a>
                                <? if (!empty($check_section)): ?>
                                <p class="faq-answer">
                                    <span><?= nl2br(Html::encode($question->answer_text)) ?></span>
                                </p>
                                <? endif; ?>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </li>
            </ul>
            <? endforeach; ?>

        <? endif; ?>
    </div>
</div>