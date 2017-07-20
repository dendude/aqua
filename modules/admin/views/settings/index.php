<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\UsersController;

$this->title = 'Настройки';
$this->params['breadcrumbs'] = [
    ['label' => $this->title]
];

$form = ActiveForm::begin([
    'id' => 'field-form',
    // other options in config/web
]);

$inputMiddle = ['inputOptions' => ['class' => 'form-control input-middle']];
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-lg-8">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'recievers', $inputMiddle)->textarea(['rows' => 4]) ?>
            <div class="form-group form-comment">
                <div class="col-xs-offset-4 col-xs-8">
                    <small class="text-muted">Введите получателей уведомлений с сайта. Один Email адрес на строку.</small>
                </div>
            </div>
            <div class="separator"></div>
            <div class="separator"></div>
            <?= $form->field($model, 'email_username', $inputMiddle) ?>
            <?= $form->field($model, 'email_password', $inputMiddle) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'email_host', $inputMiddle) ?>
            <?= $form->field($model, 'email_port', $inputMiddle) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'email_fromname', $inputMiddle) ?>
            <?= $form->field($model, 'email_sign')->textarea(['rows' => 3, 'autofocus' => Yii::$app->request->get('sign')]) ?>
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