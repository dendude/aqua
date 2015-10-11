<?php
use yii\helpers\Html;
use app\modules\admin\controllers\FaqController;

$this->title = 'Удаление раздела вопросов';
$this->params['breadcrumbs'] = [
    ['label' => FaqController::LIST_SECTIONS, 'url' => ['sections']],
    ['label' => $this->title]
];
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-9 col-lg-6">
        <div class="alert alert-danger strong">Подтверждаете удаление?</div>
        <div class="well">
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('name') ?></label>
                <div class="col-xs-6"><?= $model->name ?></div>
            </div>
            <? if ($model->questions): ?>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right">Вложенные вопросы</label>
                <div class="col-xs-6">
                    <? foreach ($model->questions AS $fk => $faq): ?>
                    <div><?= ($fk + 1) . ') ' .  $faq->name ?></div>
                    <? endforeach; ?>
                </div>
            </div>
            <? endif; ?>
            <div class="separator"></div>
            <div class="row">
                <div class="col-xs-offset-4 col-xs-4">
                    <?= Html::a('Удалить', ['section-trash', 'id' => $model->id], ['class' => 'btn btn-danger btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
</div>