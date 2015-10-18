<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\CalculateController;
use app\helpers\Statuses;

$this->title = $model->id ? 'Редактирование сообщения обратной связи' : 'Добавление сообщения обратной связи';
$this->params['breadcrumbs'] = [
    ['label' => CalculateController::LIST_NAME, 'url' => ['list']],
    ['label' => $this->title]
];

$form = ActiveForm::begin([
    'id' => 'add-form',
    // other options in config/web
]);

$inputSmall = ['inputOptions' => ['class' => 'form-control input-small']];
$inputMiddle = ['inputOptions' => ['class' => 'form-control input-middle']];
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-9 col-lg-6">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'name', $inputMiddle) ?>
            <?= $form->field($model, 'email', $inputMiddle) ?>
            <?= $form->field($model, 'phone', $inputMiddle) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'message')->textarea(['rows' => 5]) ?>
            <div class="separator"></div>
            <? if ($model->id): ?>
            <?= $form->field($model, 'answer')->textarea(['rows' => 5]) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'status')->checkbox(['label' => 'Отправить ответ на Email пользователю',
                                                          'value' => Statuses::STATUS_ACTIVE,
                                                        'uncheck' => Statuses::STATUS_USED]) ?>
            <div class="separator"></div>
            <? endif; ?>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-2">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>