<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\VideosController;

$action = $model->id ? 'Редактирование видеозаписи' : 'Добавление видеозаписи';
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => VideosController::LIST_NAME, 'url' => ['list']],
    ['label' => $action]
];

$form = ActiveForm::begin();
echo Html::activeHiddenInput($model, 'id');

$w100 = ['inputOptions' => ['class' => 'form-control w-100']];
?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12 col-md-10">
            <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
            <? \app\helpers\MHtml::alertMsg(); ?>
            <div class="well">
                <?= $form->field($model, 'title') ?>
                <?= $form->field($model, 'about')->textarea() ?>
                <div class="separator"></div>
                <?= $form->field($model, 'video_url')->textInput() ?>
                <div class="row form-info">
                    <div class="col-xs-12 col-md-offset-4 col-md-8">
                        <small class="text-muted">Пример: https://youtu.be/mpMBiEUwKLk или https://www.youtube.com/watch?v=mpMBiEUwKLk</small>
                    </div>
                </div>
                
                <?= $form->field($model, 'preview_url')->textInput(['readonly' => true, 'placeholder' => 'Сформируется автоматически']) ?>
                <div class="separator"></div>
                <div class="separator"></div>
                <?= $form->field($model, 'ordering', $w100)->input('number') ?>
                <div class="separator"></div>
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