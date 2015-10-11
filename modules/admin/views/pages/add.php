<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PagesController;

$action = $model->id ? 'Редактирование страницы' : 'Создание страницы';
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => PagesController::LIST_NAME, 'url' => ['list']],
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

$readonly_alias = in_array($model->id, [\app\models\News::PAGE_ID,
                                        \app\models\Results::PAGE_ID,
                                        \app\models\Faq::PAGE_ID,
                                        \app\models\Actions::PAGE_ID]);

?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'title') ?>
            <?= \app\helpers\MHtml::aliasField($model, 'alias', 'alias', $readonly_alias) ?>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-8 text-muted small">
                    Пример: вводим "справочник/раздел/статья1", клик "Получить URL" покажет "spravochnik/razdel/statya1".<br/>
                    После сохранения ссылка из меню на страницу будет такой: "spravochnik/razdel/statya1.html".
                </div>
            </div>
            <div class="separator"></div>
            <?= $form->field($model, 'is_shared')->checkbox(['label' => 'Показывать кнопки "Поделиться"']) ?>
            <?= $form->field($model, 'is_sitemap')->checkbox(['label' => 'Добавить страницу в карту сайта']) ?>
            <?= $form->field($model, 'is_auto')->checkbox(['label' => 'Страница наполняется автоматически', 'onclick' => "set_auto_alias(this)"]) ?>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-8">
                    <small class="text-muted">Примеры автоматических страниц: форма обратной связи, список новостей, регистрация и т.п.</small>
                </div>
            </div>
            <div class="separator"></div>
            <div class="form-group">
                <label class="control-label col-xs-4">
                    <?= $model->getAttributeLabel('breadcrumbs') ?>
                </label>
                <div class="col-xs-8">
                    <div class="input-group">
                        <?= Html::dropDownList('add_breadcrumb', null, $pages, ['id' => 'add_breadcrumb',
                                                                             'class' => 'form-control input-middle',
                                                                            'prompt' => '']) ?>
                        <span class="input-group-btn">
                            <a class="btn btn-info" onclick="add_breadcrumb('#add_breadcrumb', '#put_breadcrumb'); return false">Добавить</a>
                        </span>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'crumb')->textInput(['onkeyup' => "set_crumb(this, '#put_crumb')"]) ?>
            <div class="form-group">
                <label class="control-label col-xs-4" for="">Вид крошек на странице</label>
                <div class="col-xs-8">
                    <div id="put_breadcrumb" class="well well-sm">
                        <!--для сохранения пустых крошек-->
                        <input type="hidden" name="Pages[breadcrumbs][]" value=""/>
                        <span><i class="glyphicon glyphicon-home"></i>&nbsp;&nbsp;Главная</span>
                        <? if ($model->id): ?>
                            <? if (!empty($model->breadcrumbs) && is_array($model->breadcrumbs)): ?>
                            <? foreach ($model->breadcrumbs AS $page_id): ?>
                                <? if (isset($pages[$page_id])): ?>
                                <span> &raquo;
                                    <span class="crumb-<?= $page_id ?>">
                                        <?= $pages[$page_id] ?><input type="hidden" name="Pages[breadcrumbs][]" value="<?= $page_id ?>" />
                                        (<a href="" onclick="$(this).parent().parent().remove();return false">удалить</a>)
                                    </span>
                                </span>
                                <? endif; ?>
                            <? endforeach; ?>
                            <? endif; ?>
                        <span id="put_crumb"> &raquo; <?= $model->crumb ?></span>
                        <? else: ?>
                        <span id="put_crumb"></span>
                        <? endif; ?>
                    </div>
                </div>
            </div>
            <div class="separator"></div>
            <div class="form-group">
                <label class="control-label col-xs-4">
                    <?= $model->getAttributeLabel('vcrumbs') ?>
                </label>
                <div class="col-xs-8">
                    <div class="input-group">
                        <?= Html::dropDownList('add_vcrumbs', null, $pages, ['id' => 'add_vcrumbs',
                            'class' => 'form-control input-middle',
                            'prompt' => '']) ?>
                        <span class="input-group-btn">
                            <a class="btn btn-info" onclick="add_vbreadcrumb('#add_vcrumbs', '#put_vcrumbs'); return false">Добавить</a>
                        </span>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-xs-4" for="">Вид дополнительных крошек</label>
                <div class="col-xs-8">
                    <div id="put_vcrumbs" class="well well-sm">
                        <!--для сохранения пустых крошек-->
                        <input type="hidden" name="Pages[vcrumbs][]" value=""/>
                        <span>&nbsp;</span>
                        <? if ($model->id): ?>
                            <? if (!empty($model->vcrumbs) && is_array($model->vcrumbs)): ?>
                            <? foreach ($model->vcrumbs AS $page_id): ?>
                                <? if (isset($pages[$page_id])): ?>
                                    <span>
                                        <span class="crumb-<?= $page_id ?>">
                                            <?= $pages[$page_id] ?><input type="hidden" name="Pages[vcrumbs][]" value="<?= $page_id ?>" />
                                            (<a href="" onclick="$(this).parent().parent().remove();return false">удалить</a>)
                                        </span>
                                    </span>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
                                <? endif; ?>
                            <? endforeach; ?>
                            <? endif; ?>
                        <? endif; ?>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-8">
                    <small class="text-muted">
                        Дополнительные хлебные крошки обычно размещаются внизу страницы и служат для поисковой оптимизации, а также для перекрестных ссылок по страницам
                    </small>
                </div>
            </div>
            <div class="separator"></div>
            <?= $form->field($model, 'meta_t')->textarea(['rows' => 2, 'onkeyup' => 'charsCalculate(this)', 'maxlength' => true]) ?>
            <?= $form->field($model, 'meta_d')->textarea(['rows' => 2, 'onkeyup' => 'charsCalculate(this)', 'maxlength' => true]) ?>
            <?= $form->field($model, 'meta_k')->textarea(['rows' => 2, 'onkeyup' => 'charsCalculate(this)', 'maxlength' => true]) ?>

            <div id="pages_content" <?= $model->is_auto ? 'class="hidden"' : '' ?>>
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
            </div>
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