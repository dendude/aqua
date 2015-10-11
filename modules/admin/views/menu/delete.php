<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\MenuController;

$this->title = 'Удаление пункта меню';
$this->params['breadcrumbs'] = [
    ['label' => MenuController::LIST_NAME, 'url' => ['list']],
    ['label' => $this->title]
];
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-9 col-lg-6">
        <div class="alert alert-danger strong">Подтверждаете удаление?</div>
        <div class="well">
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('parent_id') ?></label>
                <div class="col-xs-6"><?= $model->parent->menu_name ?></div>
            </div>
            <div class="separator"></div>
            <div class="row">
                <label class="col-xs-6 text-right"><?= $model->getAttributeLabel('menu_name') ?></label>
                <div class="col-xs-6"><?= $model->menu_name ?></div>
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