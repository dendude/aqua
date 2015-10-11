<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PhotosController;
use yii\helpers\Url;

\yii\fileupload\FileUploadAsset::register($this);

$upload_id = 'fileupload';
$this->registerJs("set_upload_button('#" . $upload_id . "');");

$action = 'Добавление фотографий';
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => PhotosController::LIST_NAME, 'url' => ['sections']],
    ['label' => $action]
];

$form = ActiveForm::begin([
    'id' => 'add-form'
    // other options in config/web
]);

$inputSmall = ['inputOptions' => ['class' => 'form-control input-small']];
$inputMiddle = ['inputOptions' => ['class' => 'form-control input-middle']];
?>
<div class="clearfix"></div>

<div class="row" style="margin-bottom: 20px">
    <div class="col-xs-12">
        <div id="dropzone" class="drop-zone">
            <span class="drop-text">Кликните или перетяните сюда фотографии для загрузки</span>
            <span class="drop-text-active">Отпустите чтобы началась загрузка</span>
            <span class="drop-text-loading">
                Загрузка фотографий...
                <span class="drop-loader"></span>
            </span>
            <input id="<?= $upload_id ?>" class="upload-btn" type="file" name="UploadForm[imageFile]" data-url="<?= Url::to(['upload']) ?>" multiple="multiple" />
        </div>
    </div>
</div>

<div class="alert alert-danger hidden" id="upload_status" style="margin-bottom: 20px"></div>

<div class="row">
    <div class="col-xs-12">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'section_id', $inputMiddle)->dropDownList(\app\models\PhotoAlbums::getFilterList()) ?>
            <div class="separator"></div>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-2">
                    <?= Html::submitButton('Сохранить фотографии', ['id' => 'save_photos', 'class' => 'btn btn-primary', 'disabled' => true]) ?>
                </div>
            </div>
            <div class="separator"></div>
            <div class="separator"></div>
            <div class="form-group">
                <div class="col-xs-12">
                    <div id="appendzone"></div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php ActiveForm::end() ?>

<div id="photo_template" class="hidden">
    <div class="photo-uploaded">
        <div class="data-image">
            <img src="" alt=""/>
            <?= Html::activeHiddenInput($model, 'img_small_arr[]') ?>
            <?= Html::activeHiddenInput($model, 'img_big_arr[]') ?>
        </div>
        <div class="data-title">
            <?= Html::activeTextInput($model, 'title_arr[]', ['class' => 'form-control', 'placeholder' => 'Название']) ?>
        </div>
        <div class="data-about">
            <?= Html::activeTextarea($model, 'about_arr[]', ['class' => 'form-control', 'placeholder' => 'Описание', 'rows' => 2]) ?>
        </div>
        <div class="data-ordering">
            <?= Html::activeTextInput($model, 'ordering_arr[]', ['class' => 'form-control', 'placeholder' => 'Порядок']) ?>
        </div>
        <div class="data-delete">
            <button class="btn btn-block btn-link" onclick="remove_uploaded_photo(this)">Удалить</button>
        </div>
    </div>
</div>
