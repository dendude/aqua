<?php
use yii\helpers\Html;
use app\modules\admin\controllers\ActionsController;

$this->title = 'Удаление акции';
$this->params['breadcrumbs'] = [
    ['label' => ActionsController::LIST_NAME, 'url' => ['list']],
    ['label' => $this->title]
];
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-9 col-lg-6">
        <div class="alert alert-danger strong">Подтверждаете удаление?</div>
        <div class="well">
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('section_id') ?></label>
                <div class="col-xs-6"><?= $model->section->name ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('menu_title') ?></label>
                <div class="col-xs-6"><?= $model->menu_title ?></div>
            </div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('title') ?></label>
                <div class="col-xs-6"><?= $model->title ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('about') ?></label>
                <div class="col-xs-6"><?= $model->about ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('created') ?></label>
                <div class="col-xs-6"><?= \app\helpers\Normalize::getFullDateByTime($model->created) ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <div class="col-xs-offset-2 col-xs-4">
                    <?= Html::a('Удалить', ['trash', 'id' => $model->id], ['class' => 'btn btn-danger btn-block']) ?>
                </div>
                <div class="col-xs-4">
                    <?= Html::a('Отмена', ['list'], ['class' => 'btn btn-default btn-block']) ?>
                </div>
            </div>
        </div>
    </div>
</div>