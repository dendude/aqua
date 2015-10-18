<?php
use yii\helpers\Html;
use app\modules\admin\controllers\FreeTravelController;

$this->title = 'Удаление заявки на бесплатный вызов';
$this->params['breadcrumbs'] = [
    ['label' => FreeTravelController::LIST_NAME, 'url' => ['list']],
    ['label' => $this->title]
];
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-9 col-lg-6">
        <div class="alert alert-danger strong">Подтверждаете удаление?</div>
        <div class="well">
            <? if ($model->manager_id): ?>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('manager_id') ?></label>
                <div class="col-xs-6"><?= $model->manager->name ?></div>
            </div>
            <div class="separator"></div>
            <? endif; ?>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('name') ?></label>
                <div class="col-xs-6"><?= $model->name ?></div>
            </div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('email') ?></label>
                <div class="col-xs-6"><?= $model->email ?></div>
            </div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('phone') ?></label>
                <div class="col-xs-6"><?= \app\helpers\Normalize::formatPhone($model->phone) ?></div>
            </div>
            <? if ($model->comment): ?>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('comment') ?></label>
                <div class="col-xs-6"><?= $model->comment ?></div>
            </div>
            <? endif; ?>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('created') ?></label>
                <div class="col-xs-6"><?= \app\helpers\Normalize::getFullDateByTime($model->created) ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <div class="col-xs-offset-4 col-xs-4">
                    <?= Html::a('Удалить', ['trash', 'id' => $model->id], ['class' => 'btn btn-danger btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
</div>