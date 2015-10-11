<?php
use yii\helpers\Html;
use app\modules\admin\controllers\ActionsController;

$this->title = 'Удаление раздела акций';
$this->params['breadcrumbs'] = [
    ['label' => ActionsController::LIST_SECTIONS, 'url' => ['sections']],
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
            <? if ($model->actions): ?>
                <div class="separator"></div>
                <div class="row">
                    <label class="col-xs-6 text-right">Вложенные акции</label>
                    <div class="col-xs-6">
                        <? foreach ($model->actions AS $key => $data): ?>
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