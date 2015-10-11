<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\ResultsController;

$action = $model->id ? 'Редактирование результата' : 'Создание результата';
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => ResultsController::LIST_NAME, 'url' => ['list']],
    ['label' => $action]
];

$form = ActiveForm::begin([
    'id' => 'field-form',
    // other options in config/web
]);
echo Html::activeHiddenInput($model, 'id');

$inputSmall = ['inputOptions' => ['class' => 'form-control input-small']];
$inputMiddle = ['inputOptions' => ['class' => 'form-control input-middle']];

$pages = \app\models\Pages::getFilterList();

if ($model->id) {
    // для показа кол-ва символов у редактируемой страницы
    $this->registerJs("$('textarea').keyup();");
}

?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'section_id', $inputMiddle)->dropDownList(\app\models\ResultsSections::getFilterList()) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'menu_title', $inputMiddle) ?>
            <?= $form->field($model, 'title') ?>
            <?= \app\helpers\MHtml::aliasField($model, 'alias', 'alias') ?>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-8 text-muted small">
                    Пример: вводим "справочник/раздел/статья1", клик "Получить URL" покажет "spravochnik/razdel/statya1".<br/>
                    После сохранения ссылка из меню на страницу будет такой: "spravochnik/razdel/statya1.html".
                </div>
            </div>
            <div class="separator"></div>
            <?= $form->field($model, 'about')->textarea(['rows' => 3]) ?>
            <div class="separator"></div>
            <?= $form->field($model, 'meta_t')->textarea(['rows' => 2, 'onkeyup' => 'charsCalculate(this)', 'maxlength' => true]) ?>
            <?= $form->field($model, 'meta_d')->textarea(['rows' => 2, 'onkeyup' => 'charsCalculate(this)', 'maxlength' => true]) ?>
            <?= $form->field($model, 'meta_k')->textarea(['rows' => 2, 'onkeyup' => 'charsCalculate(this)', 'maxlength' => true]) ?>
            <div class="separator"></div>

            <?= $form->field($model, 'content', ['template' => '<div class="col-xs-4 text-left">{label}</div><div class="col-xs-8">{error}</div>']) ?>

            <?= yii\imperavi\Widget::widget([
                // You can either use it for model attribute
                'model' => $model,
                'attribute' => 'content',

                // Some options, see http://imperavi.com/redactor/docs/
                'options' => [
                    'lang' => 'ru',
                    'toolbar' => true,
                    'imageUpload' => \yii\helpers\Url::to(['upload']),
                    'imageUploadParam' => 'UploadForm[imageFile]',
                    'imageResizable' => true,
                    'imageFloatMargin' => '20px'
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
                <li>Между текстом и фото переносов строк не делаем - проставляются автоматически на сайте;</li>
                <li>Основной заголовок страницы (Н1) берется из соответствующего поля, поэтому в текст добавляем только Н2-Н6.</li>
            </ul>

            <div class="separator"></div>
            <div class="separator"></div>
            <?= $form->field($model, 'ordering', $inputSmall) ?>
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