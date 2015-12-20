<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\OrdersController;
use app\helpers\Statuses;
use app\models\Orders;

$this->title = $model->id ? 'Редактирование заказа аквариума' : 'Добавление заказа аквариума';
$this->params['breadcrumbs'] = [
    ['label' => OrdersController::LIST_NAME, 'url' => ['list']],
    ['label' => $this->title]
];

$form = ActiveForm::begin();
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-lg-9">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?
            echo '<div class="form-group">';
            echo Html::tag('div', '<label></label> - поля, обязательные для заполнения', ['class' => 'required col-xs-offset-4 col-xs-8']);
            echo '</div>';
            ?>
            <?= $form->field($model, 'aqua_type'); ?>
            <div class="separator"></div>
            <?= $form->field($model, 'name'); ?>
            <?= $form->field($model, 'email'); ?>
            <?= $form->field($model, 'phone'); ?>
            <div class="separator"></div>
            <?= $form->field($model, 'view_type')->dropDownList(Orders::getViewTypes()); ?>
            <?= $form->field($model, 'service_type')->dropDownList(Orders::getServicesTypes()); ?>
            <div class="separator"></div>
            <?= $form->field($model, 'comment')->textarea(); ?>
            <div class="separator"></div>
            <?= $form->field($model, 'status')->checkbox(['label' => 'Отметить как обработанный',
                                                          'value' => Statuses::STATUS_ACTIVE,
                                                        'uncheck' => Statuses::STATUS_USED]) ?>
            <div class="separator"></div>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-2">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>