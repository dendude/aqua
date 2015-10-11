<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PhotosController;

$action = 'Редактирование фотографии';
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => PhotosController::LIST_NAME, 'url' => ['sections']],
    ['label' => $model->section->name, 'url' => ['list', 'id' => $model->section_id]],
    ['label' => $action]
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
            <?= $form->field($model, 'section_id', $inputMiddle)->dropDownList(\app\models\PhotoAlbums::getFilterList()) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'title', $inputMiddle) ?>
            <?= $form->field($model, 'about', $inputMiddle)->textarea(['rows' => 3]) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'ordering', $inputSmall) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'status')->checkbox(['label' => 'Опубликовать в альбоме']) ?>
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