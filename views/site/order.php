<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use app\models\Pages;
use app\helpers\Normalize;
use app\models\Orders;

$this->title = $model->title;
$this->params['meta_t'] = $model->meta_t;
$this->params['meta_d'] = $model->meta_d;
$this->params['meta_k'] = $model->meta_k;
$this->params['breadcrumbs'] = $model->getBreadcrumbs();
$this->params['banner_name'] = $model->banner_name;
?>
<div class="page-content">
    <div class="page-container page-simple">
        <h1 class="page-title"><?= $model->title ?></h1>

        <p>
            Для заказа аквариума "<strong><?= Yii::$app->request->get('type', 'Не выбран'); ?></strong>" компании "<strong>Альфаро</strong>" заполните пожалуйста следующие поля:
        </p>

        <?
        $model = new Orders();
        $model->aqua_type = Yii::$app->request->get('type', 'Не выбран');

        $form = ActiveForm::begin([
            'action' => [Normalize::fixAlias(Pages::ORDER_ID_AQUA)],
            'enableClientScript' => true,
            'enableClientValidation' => true,
            'options' => ['class' => 'form-horizontal ajax-form'],
            'fieldConfig' => [
                'template' => '<div class="col-xs-4 text-right">{label}</div><div class="col-xs-6">{input}{error}</div>'
            ],
        ]);
        ?>

        <div class="well well-sm">
            <div class="form-group">
                <div class="required col-xs-offset-4 col-xs-8">
                    <label></label> - поля, обязательные для заполнения
                </div>
            </div>
            <?= $form->field($model, 'aqua_type') ?>
            <?= $form->field($model, 'name') ?>
            <?= $form->field($model, 'email') ?>
            <?= $form->field($model, 'phone') ?>
            <div class="separator"></div>
            <?= $form->field($model, 'view_type')->dropDownList(Orders::getViewTypes()) ?>
            <?= $form->field($model, 'service_type')->dropDownList(Orders::getServicesTypes()) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'comment')->textarea(['placeholder' => 'Дополнительная информация или пожелания к заказу']) ?>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-8">
                    <button class="btn btn-primary">Отправить заказ</button>
                </div>
            </div>
        </div>

        <? $form::end(); ?>
    </div>
</div>