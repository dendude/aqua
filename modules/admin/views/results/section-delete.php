<?php
use yii\helpers\Html;
use app\modules\admin\controllers\ResultsController;

$this->title = 'Удаление раздела результатов';
$this->params['breadcrumbs'] = [
    ['label' => ResultsController::LIST_SECTIONS, 'url' => ['sections']],
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
            <? if ($model->results): ?>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right">Вложенные результаты</label>
                <div class="col-xs-6">
                    <? foreach ($model->results AS $key => $data): ?>
                    <div><?= ($key + 1) . ') ' .  $data->title ?></div>
                    <? endforeach; ?>
                </div>
            </div>
            <? endif; ?>
            <div class="separator"></div>
            <div class="row">
                <div class="col-xs-offset-2 col-xs-4">
                    <?= Html::a('Удалить', ['section-trash', 'id' => $model->id], ['class' => 'btn btn-danger btn-block']) ?>
                </div>
                <div class="col-xs-4">
                    <?= Html::a('Отмена', ['sections'], ['class' => 'btn btn-default btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
</div>