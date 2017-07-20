<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\FaqController;

$this->title = $model->id ? 'Редактирование вопроса' : 'Добавление вопроса';
$this->params['breadcrumbs'] = [
    ['label' => FaqController::LIST_NAME, 'url' => ['list']],
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
            <div class="separator"></div>
            <?= $form->field($model, 'section_id')->dropDownList(\app\models\FaqSections::getFilterList()) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'bread_text') ?>
            <div class="separator"></div>
            <?= $form->field($model, 'question_text')->textarea(['rows' => 3]) ?>
            <?= $form->field($model, 'answer_text')->textarea(['rows' => 5]) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'ordering', $inputSmall) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'send_answer')->checkbox(['label' => 'Отправить ответ на Email автору вопроса']) ?>
            <?= $form->field($model, 'status')->checkbox(['label' => 'Опубликовать на сайте']) ?>
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