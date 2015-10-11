<?php
use yii\helpers\Html;
use app\modules\admin\controllers\FaqController;

$this->title = 'Удаление вопроса';
$this->params['breadcrumbs'] = [
    ['label' => FaqController::LIST_NAME, 'url' => ['list']],
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
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('email') ?></label>
                <div class="col-xs-6"><?= $model->email ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('section_id') ?></label>
                <div class="col-xs-6"><?= $model->section->name ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('question_text') ?></label>
                <div class="col-xs-6"><?= $model->question_text ?></div>
            </div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('answer_text') ?></label>
                <div class="col-xs-6"><?= $model->answer_text ?></div>
            </div>
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