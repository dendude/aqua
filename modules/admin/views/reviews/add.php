<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\ReviewsController;
use app\models\forms\UploadForm;
use yii\helpers\Url;

\yii\fileupload\FileUploadAsset::register($this);

$upload_id = 'fileupload';
$this->registerJs("set_upload_button('#" . $upload_id . "');");

$upload_id2 = 'fileupload2';
$this->registerJs("set_upload_button('#" . $upload_id2 . "', '#photo_template2', '#dropzone2', '#appendzone2', '#" . Html::getInputId($model, 'img_content') . "');");

$this->title = $model->id ? 'Редактирование отзыва' : 'Добавление отзыва';
$this->params['breadcrumbs'] = [
    ['label' => ReviewsController::LIST_NAME, 'url' => ['list']],
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

            <div class="row">
                <div class="col-xs-12">
                    <div id="dropzone" class="drop-zone">
                        <span class="drop-text drop-text drop-text-tripple">
                            <strong>Фото автора отзыва</strong><br>
                            Кликните или перетяните сюда фотографии для загрузки<br>
                            Рекомендуемое соотношение фотографии <strong>1:1</strong>
                        </span>
                        <span class="drop-text-active">Отпустите чтобы началась загрузка</span>
                        <span class="drop-text-loading">
                            Загрузка фотографий...
                            <span class="drop-loader"></span>
                        </span>
                        <input id="<?= $upload_id ?>" class="upload-btn" type="file" name="UploadForm[imageFile]" data-url="<?= Url::to(['upload']) ?>" />
                    </div>
                </div>
            </div>

            <div class="row m-t">
                <div class="col-xs-offset-4 col-xs-8">
                    <?= Html::activeHiddenInput($model, 'img_name', ['value' => '']) ?>
                    <div id="appendzone" class="review-img">
                        <? if ($model->img_name): ?>
                            <div class="photo-uploaded">
                                <div class="data-image">
                                    <?= Html::img(UploadForm::getSrc($model->img_name, UploadForm::TYPE_REVIEWS)) ?>
                                    <?= Html::activeHiddenInput($model, 'img_name') ?>
                                </div>
                                <div class="data-delete">
                                    <button class="btn btn-block btn-link" onclick="remove_uploaded_photo(this)">Удалить</button>
                                </div>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            </div>

            <div class="separator"></div>

            <div class="row">
                <div class="col-xs-12">
                    <div id="dropzone2" class="drop-zone">
                        <span class="drop-text drop-text drop-text-double">
                            <strong>Фото в содержимом отзыва</strong><br>
                            Кликните или перетяните сюда фотографии для загрузки<br>
                        </span>
                        <span class="drop-text-active">Отпустите чтобы началась загрузка</span>
                        <span class="drop-text-loading">
                            Загрузка фотографий...
                            <span class="drop-loader"></span>
                        </span>
                        <input id="<?= $upload_id2 ?>" class="upload-btn" type="file" name="UploadForm[imageFile]" data-url="<?= Url::to(['upload']) ?>" />
                    </div>
                </div>
            </div>
            <div class="row m-t">
                <div class="col-xs-offset-4 col-xs-8">
                    <?= Html::activeHiddenInput($model, 'img_content', ['value' => '']) ?>
                    <div id="appendzone2" class="review-img">
                        <? if ($model->img_content): ?>
                            <div class="photo-uploaded">
                                <div class="data-image">
                                    <?= Html::img(UploadForm::getSrc($model->img_content, UploadForm::TYPE_REVIEWS)) ?>
                                    <?= Html::activeHiddenInput($model, 'img_content') ?>
                                </div>
                                <div class="data-delete">
                                    <button class="btn btn-block btn-link" onclick="remove_uploaded_photo(this)">Удалить</button>
                                </div>
                            </div>
                        <? endif; ?>
                    </div>
                </div>
            </div>

            <div class="separator"></div>

            <?= $form->field($model, 'comment')->textarea(['rows' => 5]) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'ordering', $inputSmall) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'send_mail')->checkbox(['label' => 'Отправить уведомление автору отзыва']) ?>
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

<div id="photo_template" class="hidden">
    <div class="photo-uploaded">
        <div class="data-image">
            <?= Html::img(UploadForm::getSrc($model->img_name, UploadForm::TYPE_REVIEWS)) ?>
            <?= Html::activeHiddenInput($model, 'img_name') ?>
        </div>
        <div class="data-delete">
            <button class="btn btn-block btn-link" onclick="remove_uploaded_photo(this)">Удалить</button>
        </div>
    </div>
</div>

<div id="photo_template2" class="hidden">
    <div class="photo-uploaded">
        <div class="data-image">
            <?= Html::img(UploadForm::getSrc($model->img_content, UploadForm::TYPE_REVIEWS)) ?>
            <?= Html::activeHiddenInput($model, 'img_content') ?>
        </div>
        <div class="data-delete">
            <button class="btn btn-block btn-link" onclick="remove_uploaded_photo(this)">Удалить</button>
        </div>
    </div>
</div>