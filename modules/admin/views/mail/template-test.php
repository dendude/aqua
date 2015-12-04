<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\MailController;

$this->title = $model->id ? 'Редактирование шаблона писем' : 'Добавление шаблона писем';
$this->params['breadcrumbs'] = [
    ['label' => MailController::LIST_TEMPLATES, 'url' => ['templates']],
    ['label' => $this->title]
];

$form = ActiveForm::begin([
    'id' => 'add-form',
    // other options in config/web
]);

\yii\ckeditor\CKEditorAsset::register($this);
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8">
        <div class="well">
            <?= $form->field($model, 'subject') ?>
            <div class="separator"></div>

            <?= $form->field($model, 'content', ['template' => '<div class="col-xs-4 text-left">{label}</div><div class="col-xs-8">{error}</div>']) ?>
            <?= $form->field($model, 'content', ['template' => '<div class="col-xs-12">{input}</div>']) ?>

            <?
            $this->registerJs("
                CKEDITOR.replace('" . Html::getInputId($model, 'content') . "', {
                    width: '100%',
                    extraPlugins: 'autogrow',
                    autoGrow_minHeight: 200,
                    autoGrow_maxWidth: '100%',
                    resize_dir: 'both',
                    uploadUrl: '" . \yii\helpers\Url::to(['upload']) . "'
                });
            ");
            ?>
        </div>
    </div>
</div>
<?php ActiveForm::end() ?>