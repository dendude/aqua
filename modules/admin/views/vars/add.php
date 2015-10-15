<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\VarsController;

$this->title = $model->id ? 'Редактирование текстовой переменной' : 'Добавление текстовой переменной';
$this->params['breadcrumbs'] = [
    ['label' => VarsController::LIST_NAME, 'url' => ['list']],
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
    <div class="col-xs-12 col-md-10">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'value', $inputMiddle)->textarea(['rows' => 10]) ?>
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