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
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'subject') ?>
            <div class="separator"></div>

            <?= $form->field($model, 'content', ['template' => '<div class="col-xs-4 text-left">{label}</div><div class="col-xs-8">{error}</div>']) ?>

            <?= yii\imperavi\Widget::widget([
                // You can either use it for model attribute
                'model' => $model,
                'attribute' => 'content',
                'id' => Html::getInputId($model, 'content'),

                // Some options, see http://imperavi.com/redactor/docs/
                'options' => [
                    'lang' => 'ru',
                    'toolbar' => true,
                    'imageUpload' => \yii\helpers\Url::to(['upload']),
                    'imageUploadParam' => 'UploadForm[imageFile]',
                    'imageResizable' => true,
                ],
                'plugins' => [
                    'myplugins',
                    'table',
                    'video',
                    'fontcolor',
                    'fontsize',
                    'fullscreen',
                ]
            ]); ?>
            <ul>
                <li><strong>Enter</strong> - перенос строки с отступом (новый параграф);</li>
                <li><strong>Shift+Enter</strong> - перенос без отступа (обычный перенос строки);</li>
                <li><strong>{name}</strong> - автоподстановка имени пользователя</li>
                <li><strong>{email}</strong> - автоподстановка Email пользователя</li>
                <li><strong>{sitename}</strong> - автоподстановка сайта</li>
                <li>Между текстом и фото переносов строк не делаем - проставляются автоматически на сайте;</li>
                <li>Основной заголовок страницы (Н1) берется из соответствующего поля, поэтому в текст добавляем только Н2-Н6.</li>
            </ul>
            <div class="separator"></div>
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