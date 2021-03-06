<?php
use yii\helpers\Html;
use app\modules\admin\controllers\CalculateController;

$this->title = 'Удаление заявки на расчет аквариума';
$this->params['breadcrumbs'] = [
    ['label' => CalculateController::LIST_NAME, 'url' => ['list']],
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
            <div class="separator"></div>
            <? if ($model->phone): ?>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('phone') ?></label>
                <div class="col-xs-6"><?= \app\helpers\Normalize::formatPhone($model->phone) ?></div>
            </div>
            <? endif; ?>
            <div class="separator"></div>
            <? foreach ($model->dop_params AS $pk): ?>
                <? if ($model->{$pk}): ?>
                    <div class="row">
                        <label class="col-xs-6 text-right"><?= $model->getAttributeLabel($pk) ?></label>
                        <div class="col-xs-6">
                        <?
                        switch ($pk) {
                            case 'param_oform_type':
                                echo $model->getOformName($model->{$pk});
                                break;

                            case 'param_has_krishka':
                            case 'param_has_tumba':
                            case 'param_has_oborud':
                                echo 'Да';
                                break;

                            default:
                                echo $model->{$pk} . ' (см)';
                        }
                        ?>
                        </div>
                    </div>
                <? endif; ?>
            <? endforeach; ?>
            <? if ($model->message): ?>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('message') ?></label>
                <div class="col-xs-6"><?= $model->message ?></div>
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