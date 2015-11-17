<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PagesController;
use app\models\Menu;
use yii\tinymce\TinyMceAsset;

TinyMceAsset::register($this);

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

$root_menu = Menu::find()->root()->all();
$menu_filter = $root_menu ? \yii\helpers\ArrayHelper::map($root_menu, 'id', 'menu_name') : [];

?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-md-10 col-lg-8">
        <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?= $form->field($model, 'title') ?>
            <?= \app\helpers\MHtml::aliasField($model, 'alias', 'alias') ?>
            <?= \app\helpers\MHtml::aliasField($model, 'alias_new', 'alias_new', false, 'Если заполнено - сюда будет происходить 301 редирект') ?>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-8 text-muted small">
                    Пример: вводим "справочник/раздел/статья1", клик "Получить URL" покажет "spravochnik/razdel/statya1".<br/>
                    После сохранения ссылка из меню на страницу будет такой: "spravochnik/razdel/statya1.html".
                </div>
            </div>
            <div class="separator"></div>
            <?= $form->field($model, 'menu_id')->dropDownList($menu_filter, ['prompt' => '']) ?>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-8">
                    <small class="text-muted">Подключенное меню стилизуется согласно дизайна</small>
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
                <?= $form->field($model, 'content', ['template' => '<div class="col-xs-12 text-left">{label}</div><br/><br/><div class="col-xs-12">{input}{error}</div>'])->textarea() ?>
                <ul>
                    <li>Стилизация блоков через код</li>
                    <li><strong><?= htmlspecialchars('<p class="blue-block">какой-то текст</p>'); ?></strong> - пример стилизации синего блока через правку кода;</li>
                    <li><strong><?= htmlspecialchars('<p class="orange-block">какой-то текст</p>'); ?></strong> - пример стилизации оранжевого блока;</li>
                    <li><strong><?= htmlspecialchars('<p class="blue-block left">какой-то текст</p>'); ?></strong> - пример стилизации синего блока с выравниванием слева, right - справа;</li>
                    <li><strong><?= htmlspecialchars('<p class="orange-block right">какой-то текст</p>'); ?></strong> - пример стилизации оранжевого блока с выравниванием справа, left - слева;</li>
                </ul>
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
<?
$this->registerJs('


    tinymce.init({
        selector: "#' . Html::getInputId($model, 'content') . '",

        language_url: "/js/langs/ru.js",

        min_height: 500,

        convert_urls: false,
        relative_urls: true,

        document_base_url: "/",

        content_css: [
            "/css/site_mod.css?20151117",
            "/lib/bootstrap/dist/css/bootstrap.min.css"
        ],

        plugin_preview_width: 1050,
        plugin_preview_height: 600,

        code_dialog_width: 1050,
        code_dialog_height: 600,

        table_advtab: true,
        table_default_attributes: {
            class: "table table-bordered table-striped table-condensed table-hover"
        },
        table_class_list: [
            {title: "Без форматирования", value: ""},
            {title: "С полной разметкой", value: "table table-bordered table-striped table-condensed table-hover"},
            {title: "С внутренними отступами", value: "table-padding5"},
            {title: "С внутренними отступами и центрирование в ячейках", value: "table-center table-padding5"},
        ],

        images_upload_url: "' . \yii\helpers\Url::to(['upload']) . '",
        images_upload_base_path: "/images",
        images_upload_credentials: true,
        image_advtab: true,
        image_class_list: [
            {title: "Без выравнивания", value: ""},
            {title: "Влево", value: "pull-left"},
            {title: "Вправо", value: "pull-right"},
            {title: "По центру", value: "pull-center"},
        ],
        image_list: [
            {title: "Рыбка синяя", value: "/images/fish2.gif"}
        ],

        contextmenu: "anchor link | inserttable cell row column deletetable",

        templates: [
            {title: "Blue Block", description: "Синий блок", content: "<p class=\"blue-block\"></p>"},
            {title: "Blue Block Left", description: "Синий блок слева", content: "<p class=\"blue-block left\"></p>"},
            {title: "Blue Block Right", description: "Синий блок справа", content: "<p class=\"blue-block right\"></p>"},
            {title: "Orange Block", description: "Оранжевый блок", content: "<p class=\"orange-block\"></p>"},
            {title: "Orange Block Left", description: "Оранжевый блок слева", content: "<p class=\"orange-block left\"></p>"},
            {title: "Orange Block Right", description: "Оранжевый блок справа", content: "<p class=\"orange-block right\"></p>"},
        ],

        plugins: [
            "advlist autolink lists link charmap hr print preview anchor",
            "searchreplace visualblocks code fullscreen wordcount",
            "insertdatetime media table contextmenu paste media directionality",
            "template paste textcolor colorpicker textpattern image imagetools"
        ],

        toolbar1: "code | insertfile undo redo | copy cut paste searchreplace | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist | styleselect | fullscreen",
        toolbar2: "preview | bold italic underline strikethrough | removeformat | forecolor backcolor | anchor link insertfile image media"
    });
');
?>
