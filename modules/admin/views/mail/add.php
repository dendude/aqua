<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\MenuController;

$this->title = $model->id ? 'Редактирование пункта меню' : 'Добавление пункта меню';
$this->params['breadcrumbs'] = [
    ['label' => MenuController::LIST_NAME, 'url' => ['list']],
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
    <div class="col-xs-12 col-md-10 col-lg-8">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'parent_id', $inputMiddle)->dropDownList(\app\models\Menu::getFilterList(true), ['encode' => false, 'prompt' => '--', 'disabled' => ($model->parent_id == 0)]) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'menu_name', $inputMiddle) ?>
            <?= $form->field($model, 'menu_title', $inputMiddle) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'page_id', $inputMiddle)->dropDownList(\app\models\Pages::getFilterList(), ['prompt' => '']) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'status')->checkbox() ?>
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