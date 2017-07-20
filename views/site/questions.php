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
$this->params['banner_name'] = $model->banner_name;

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
        <div class="pull-right">
            <a class="page-question faq-add" data-target="#modal_form_<?= Faq::PAGE_ADD_ID ?>" data-toggle="modal">
                <?= Yii::$app->vars->val(103) ?>
            </a>
        </div>
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

                            <?
                            $dom = new \app\components\simple_html_dom($question->answer_text);
                            if ($dom->find('a')) {
                                foreach ($dom->find('a') AS $a) {
                                    if (empty($a->href)) continue;
                                    $a->href = str_replace(['.html', '.php'], '', $a->href);
                                    $a->href = Url::to([Normalize::fixAlias($a->href)]);
                                }
                            }
                            ?>

                            <li>
                                <a href="<?= Url::to([Faq::ALIAS_PREFIX, 'id' => $question->id]) ?>" onclick="show_answer(this, event)"><?= nl2br(Html::encode($question->question_text)) ?></a>
                                <p class="faq-answer"><span><strong>Ответ:</strong>&nbsp;<?= nl2br($dom->outertext) ?></span></p>
                            </li>
                        <? endforeach; ?>
                    </ul>
                </li>
            </ul>
            <? endforeach; ?>

        <? endif; ?>
    </div>
</div>