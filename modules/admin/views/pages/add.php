<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\PagesController;
use app\models\Menu;
use yii\tinymce\TinyMceAsset;
use \app\models\Pages;

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
            <? if ($model->id): ?>
                <div class="form-group" style="margin: -10px 0 15px 0;">
                    <div class="col-xs-offset-4 col-xs-8">
                        <a href="<?= \app\models\Pages::SITE_URL . '/' . trim($model->alias, '/') ?>.php" target="_blank">Ссылка на сайт-источник &raquo;</a>
                    </div>
                </div>
            <? endif; ?>
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

            <div class="form-group">
                <label class="control-label col-xs-4">
                    <?= $model->getAttributeLabel('banner_name') ?>
                </label>
                <div class="col-xs-8">
                    <div class="banner-cont">
                        <table>
                            <tr>
                                <td style="padding: 0 3px">
                                    <p class="form-control-static">
                                        <label for="banner_off">
                                            <? $checked = empty($model->banner_name) ? 'checked="checked"' : ''; ?>
                                            <input id="banner_off" name="<?= Html::getInputName($model, 'banner_name') ?>" <?= $checked ?> value="" type="radio"/>
                                        </label>
                                    </p>
                                </td>
                                <td style="padding: 0 3px">
                                    <p class="form-control-static">
                                        <label for="banner_off" class="cur-p">Не использовать баннер</label>
                                    </p>
                                </td>
                            </tr>
                            <?
                            $top_banners = \app\models\Photos::find()
                                ->where(['section_id' => \app\models\PhotoAlbums::ALBUM_BANNERS,
                                             'status' => \app\helpers\Statuses::STATUS_ACTIVE])
                                ->orderBy('ordering ASC')
                                ->all();
                            if ($top_banners):
                                foreach ($top_banners AS $bk => $banner):
                            ?>
                            <tr title="Выбрать баннер">
                                <td style="padding: 3px">
                                    <label for="banner_<?= $bk ?>">
                                        <? $checked = $model->banner_name == $banner->img_big ? 'checked="checked"' : ''; ?>
                                        <input id="banner_<?= $bk ?>" name="<?= Html::getInputName($model, 'banner_name') ?>" <?= $checked ?> value="<?= $banner->img_big ?>" type="radio"/>
                                    </label>
                                </td>
                                <td style="padding: 3px">
                                    <label for="banner_<?= $bk ?>" class="cur-p">
                                        <img width="100%" src="<?= \app\models\forms\UploadForm::getSrc($banner->img_big, \app\models\forms\UploadForm::TYPE_GALLERY) ?>" alt=""/>
                                    </label>
                                </td>
                            </tr>
                            <? endforeach; ?>
                            <? endif; ?>
                        </table>
                        <p>Баннеры загружаются в <?= Html::a('этом разделе', ['photos/sections']) ?></p>
                    </div>
                </div>
            </div>

            <div class="separator"></div>

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
            <div class="separator"></div>
            <div class="form-group">
                <div class="col-xs-offset-4 col-xs-2">
                    <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                </div>
            </div>
            <div id="pages_content" <?= $model->is_auto ? 'class="hidden"' : '' ?>>
                <div class="separator"></div>
                <?= $form->field($model, 'content', ['template' => '<div class="col-xs-12 text-left">{label}</div><br/><br/><div class="col-xs-12">{input}{error}</div>'])->textarea() ?>
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
<input type="hidden" value="<?= Yii::$app->request->referrer ?>" name="refpage"/>
<?php ActiveForm::end() ?>
<?
$this->registerJs('


    tinymce.init({
        selector: "#' . Html::getInputId($model, 'content') . '",

        language_url: "/js/langs/ru.js",

        min_height: 500,

        convert_urls: false,
        relative_urls: true,

        document_base_url: "",

        content_css: [
            "/lib/bootstrap/dist/css/bootstrap.min.css",
            "/css/site_mod.css?' . time() . '"
        ],

        plugin_preview_width: 1050,
        plugin_preview_height: 600,

        code_dialog_width: 1050,
        code_dialog_height: 600,

        table_advtab: true,
        table_default_attributes: {
            class: "table table-bordered table-striped table-condensed valign-top"
        },
        table_class_list: [
            {title: "Без форматирования", value: "table-auto"},
            {title: "Без форматирования с нижним подчеркиванием", value: "table-auto table-bottom-line"},
            {title: "С полной разметкой", value: "table table-bordered table-striped table-condensed table-auto valign-top"},
            {title: "С полной разметкой 100% ширина", value: "table table-bordered table-striped table-condensed valign-top"},
            {title: "С внутренними отступами", value: "table-padding5"},
            {title: "С внутренними отступами и нижним подчеркиванием", value: "table-padding5 table-bottom-line"},
            {title: "С внутренними отступами и центрирование в ячейках", value: "table-center table-padding5"},
            {title: "Стилизованная таблица для характеристик", value: "table-characters table-padding5"},
            {title: "Стилизованная таблица для характеристик 100% ширина", value: "table-characters table-padding5 table-full"},
        ],

        images_upload_url: "' . \yii\helpers\Url::to(['upload']) . '",
        images_upload_base_path: "/images",
        images_upload_credentials: true,
        image_advtab: true,
        image_class_list: [
            {title: "Без выравнивания", value: ""},
            {title: "Без выравнивания с границей", value: "image-bordered"},
            {title: "Без выравнивания с тенью", value: "image-shadow"},
            {title: "Без выравнивания с наложением", value: "image-relative"},
            {title: "Влево", value: "pull-left"},
            {title: "Вправо", value: "pull-right"},
            {title: "По центру", value: "pull-center"},
        ],
        image_list: [
            {title: "Памятный знак", value: "/news/ferplast.gif"},
            {title: "Памятный знак большой", value: "/images/ferplast.gif"},
            {title: "Памятный знак без фона", value: "/ferplast/lowfoto/logotypfer2.gif"},
            {title: "Желтая рыбка", value: "/images/labelza7.gif"},
            {title: "Рыбка синяя мал", value: "/images/labelza9.gif"},
            {title: "Рыбка синяя средняя", value: "/images/fish2.gif"}
        ],

        contextmenu: "anchor link image | inserttable cell row column deletetable",

        fontsize_formats: "8px 10px 11px 12px 13px 14px 16px 18px 24px 36px",
        fullpage_default_fontsize: "14px",

        extended_valid_elements: "script[charset|language|type|src]",

        style_formats : [
            {title : "Small text", inline : "small"},
            {title : "Big text", inline : "big"},
        ],

        templates: [
            {title: "Order button", description: "Стилизованная кнопка заказа", content: "<a href=\"#\" class=\"btn btn-primary btn-xs btn-order\">ЗАКАЗАТЬ</a>"},
            {title: "Separator line", description: "Разделительная линия", content: "<hr class=\"separator-line\" />"},
            {title: "Page H1", description: "Основной заголовок Н1 для статьи", content: "<h1 class=\"page-title\">Page H1</h1>"},

            {title: "Blue Block Left 200px", description: "Синий вертикальный блок слева", url: "' . \yii\helpers\Url::to(['templates/blue-block-left']) . '"},
            {title: "Blue Block Right 200px", description: "Синий вертикальный блок справа", url: "' . \yii\helpers\Url::to(['templates/blue-block-right']) . '"},

            {title: "Table Aqua", description: "Заготовка таблицы для аквариумов", url: "' . \yii\helpers\Url::to(['templates/table-aqua']) . '"},
            {title: "Table Image-text", description: "Заготовка таблицы фото-текст", url: "' . \yii\helpers\Url::to(['templates/table-fill']) . '"},
            {title: "Table Characters", description: "Заготовка таблицы для характеристик", url: "' . \yii\helpers\Url::to(['templates/table-characters']) . '"},

            {title: "Photo Slider", description: "Слайдер фотографий для страниц", content: "<div class=\"page-slider-cont\"><div id=\"page_slider\"><ul><li><img/></li></ul></div></div>"},

            {title: "Blue H1", description: "Синий заголовок Н1", content: "<h1 class=\"page-title blue-title\">Blue H1</h1>"},
            {title: "Blue H2", description: "Синий заголовок Н2", content: "<h2 class=\"page-title blue-title\">Blue H2</h2>"},
            {title: "Blue H3", description: "Синий заголовок Н3", content: "<h3 class=\"page-title blue-title\">Blue H3</h3>"},

            {title: "Table Content Left", description: "Таблица в контент слева", content: "<table class=\"table-text left\"><tbody><tr><td><p>image<br/>text</p></td></tr></tbody></table>"},
            {title: "Table Content Right", description: "Таблица в контент справа", content: "<table class=\"table-text right\"><tbody><tr><td><p>image<br/>text</p></td></tr></tbody></table>"},

            {title: "Gradiend Background Yellow-Blue", description: "Желто-синий фоновый градиент", content: "<div class=\"grad-bg\"><p></p></div>"},

            {title: "Blue Message", description: "Синий блок-сообщение 100%", content: "<div class=\"blue-block\"><p>Text</p></div>"},
            {title: "Blue Message Left", description: "Синий блок-сообщение слева", content: "<div class=\"blue-block left\"><p>Text</p></div>"},
            {title: "Blue Message Left 40%", description: "Синий блок-сообщение слева 40% ширины", content: "<div class=\"blue-block left width40\"><p>Text</p></div>"},
            {title: "Blue Message Left 60%", description: "Синий блок-сообщение слева 60% ширины", content: "<div class=\"blue-block left width60\"><p>Text</p></div>"},
            {title: "Blue Message Right", description: "Синий блок-сообщение справа", content: "<div class=\"blue-block right\"><p>Text</p></div>"},
            {title: "Blue Message Right 40%", description: "Синий блок-сообщение справа 40% ширины", content: "<div class=\"blue-block right width40\"><p>Text</p></div>"},
            {title: "Blue Message Right 60%", description: "Синий блок-сообщение справа 60% ширины", content: "<div class=\"blue-block right width60\"><p>Text</p></div>"},

            {title: "Orange Message", description: "Оранжевый блок-сообщение", content: "<div class=\"orange-block\"><p>Text</p></div>"},
            {title: "Orange Message Left", description: "Оранжевый блок-сообщение слева", content: "<div class=\"orange-block left\"><p>Text</p></div>"},
            {title: "Orange Message Right", description: "Оранжевый блок-сообщение справа", content: "<div class=\"orange-block right\"><p>Text</p></div>"},

            {title: "Fish List", description: "Список, маркированный рыбками, в одну строку", content: "<table class=\"fish-list bg-blue\"><tr><td><ul><li>item1</li><li>item2</li></ul><span class=\"clearfix\"></span></td></tr></table>"},
            {title: "Fish List Fixed", description: "Список, маркированный рыбками, в одну строку, с залипанием при прокрутке", content: "<table class=\"fish-list fish-list-menu bg-blue\"><tr><td><ul><li>item1</li><li>item2</li></ul><span class=\"clearfix\"></span></td></tr></table>"},
            {title: "Fish List Block", description: "Список, маркированный рыбками, построчно", content: "<table class=\"fish-list block\"><tr><td><ul><li>item1</li><li>item2</li></ul></td></tr></table>"},
        ],

        plugins: [
            "advlist autolink lists link charmap hr print preview anchor autoresize",
            "searchreplace visualblocks code fullscreen wordcount",
            "insertdatetime media table contextmenu media directionality",
            "template textcolor colorpicker textpattern image imagetools"
        ],

        toolbar1: "code | insertfile undo redo | searchreplace | alignleft aligncenter alignright alignjustify | indent outdent | bullist numlist | formatselect,fontselect,fontsizeselect,sub,sup",
        toolbar2: "preview | bold italic underline strikethrough | removeformat | forecolor backcolor | anchor link insertfile image media | fullscreen"
    });
');
?>
