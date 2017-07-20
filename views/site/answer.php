<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\helpers\Normalize;
use app\models\Faq;
use app\models\Pages;

$faq_page = Pages::findOne(Faq::PAGE_ID);
$show_length = 100;

$this->title = mb_substr(Html::encode($model->question_text), 0, $show_length, Yii::$app->charset);
if (mb_strlen($model->question_text, Yii::$app->charset) > $show_length) {
    // сохращаем вопрос для хлебных крошек
    $this->title .= '...';
}

// вопросы и ответы
$this->params['breadcrumbs'][] = ['url' => Url::to([Normalize::fixAlias($faq_page->alias)]),
                                'label' => $faq_page->crumb];
// раздел
$this->params['breadcrumbs'][] = ['url' => Url::to(['site/page', 'alias' => $faq_page->alias, 'id' => $model->section_id]),
                                'label' => $model->section->name];
// вопрос
$this->params['breadcrumbs'][] = $model->bread_text;

$this->params['banner_name'] = $faq_page->banner_name;

$dom = new \app\components\simple_html_dom($model->answer_text);
if ($dom->find('a')) {
    foreach ($dom->find('a') AS $a) {
        if (empty($a->href)) continue;
        $a->href = str_replace(['.html', '.php'], '', $a->href);
        $a->href = Url::to([Normalize::fixAlias($a->href)]);
    }
}
$model->answer_text = $dom->outertext;
?>
<div class="page-content">
    <div class="page-container page-simple">
        <div class="pull-right" style="margin-left: 50px;">
            <a class="page-question faq-add" data-target="#modal_form_<?= Faq::PAGE_ADD_ID ?>" data-toggle="modal">
                <?= Yii::$app->vars->val(103) ?>
            </a>
        </div>
        <h1 class="page-title"><?= Html::encode($model->question_text) ?></h1>
        <p class="faq-author">Автор: <?= nl2br(Html::encode($model->name)) ?></p>
        <hr/>
        <p class="faq-question">
            <div><strong>Ответ</strong></div>
            <?= nl2br($model->answer_text) ?>
        </p>
        <hr/>
        <p class="faq-created"><?= Normalize::getDateByTime($model->created) ?></p>
    </div>
</div>





<div class="blue-block right width40">
    <ul>
        <li>Размеры стандартных аквариумов в разделе&nbsp;<a href="/price.php" target="_blank">"Цены на аквариумы"</a>.</li>
        <li>Стандартное оборудование на странице - "<a href="/equipprice.php" target="_blank">Базовые комплекты оборудования</a>".</li>
        <li>Аквариум произвольной формы, по Вашим размерам, можно заказать на странице "<a href="/order.php" target="_blank">Заказ аквариума</a>".</li>
    </ul>
</div>
<p><img src="/images/fish2.gif" alt="" width="32" height="22" align="absmiddle" /> Изготовление и <strong>продажа аквариумов</strong> основной профиль компании. <em>Продажа аквариумов</em>, спроектированных для розничной торговли, дает нам возможность расширить ассортимент. Небольшие партии изготавливаются для зоомагазинов, посредников, а также для других аквариумных фирм. Товар реализуется - экспозиция меняется - уточняйте, пожалуйста, наличие конкретных моделей по нашим телефонам. В любом случае, Вы можете сделать заказ.<br /> Цены указаны на продажу аквариумов в базовой комплектации: с крышкой-светильником и лампами, без оборудования (фильтры, нагреватели, термометры и т.д.). Комплект оборудования можно приобрести у нас отдельно.</p>
<ul>
    <li>Гарантия - 1 год. Покупку можно забрать самовывозом, либо оплатить доставку по ценам, отраженным на странице <a href="/serviceprice.php" target="_blank">"Услуги по оформлению и обслуживанию"</a>. Мы также предлагаем оформление и обслуживание купленных аквариумов. При заключении договора на абонентское обслуживание, <strong>гарантия от протечки продлевается до 5-ти лет.</strong><br /> Для того, чтобы купить аквариум, звоните по телефонам: <strong>тел. +7(985)921-5206, тел-факс +7(495)755-7874.</strong></li>
</ul>
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px;">№1</span>
            <table style="font-size: 14px;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/klass_massiv.jpg" alt="Классический аквариум 500л, отделка - массив ореха" height="180" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Классика"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;<span style="color: #333333; font-size: 14px; text-align: center;">500л</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="font-size: 14px; font-weight: bold; color: #333333; text-align: center;">Аквариум</span><span style="color: #333333; font-size: 14px; text-align: center;">&nbsp;(с крышкой):</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">длина - 1м 37см;</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">ширина - 62см;</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">высота - 76см.</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="font-size: 14px; font-weight: bold; color: #333333; text-align: center;">Высота тумбы</span><span style="color: #333333; font-size: 14px; text-align: center;">:</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">высота - 85см.</span></td>
                    <td style="text-align: center;">&nbsp;<span style="color: #333333; font-size: 14px;">массив орех</span></td>
                    <td style="text-align: center;"><span style="color: #333333; font-size: 14px;">140 000р.</span></td>
                    <td style="text-align: center;">&nbsp;-</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="width: 160px; text-align: center; vertical-align: top;">
            <p>№2</p>
            <p><img class="image-shadow" style="font-size: 14px; text-align: left; background-color: #f9f9f9;" src="/selloff/lowfoto/tower_270.jpg" alt="Аквариум-башня 270л, венге" height="180" vspace="7" /></p>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Башня шестигранная"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;270л<br /><strong>Аквариум</strong>:<br />акриловое стекло<br />ширина - 51см;<br />высота - 2м 14см.</td>
                    <td style="text-align: center;">&nbsp;венге</td>
                    <td style="text-align: center;">&nbsp;76 000р</td>
                    <td style="text-align: center;">-&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№3</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/klass01.jpg" alt="" width="111" height="150" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Классика-240"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;240л<br /><strong>Аквариум</strong>&nbsp;(с крышкой):<br />длина - 1м 2см;<br />ширина - 46см;<br />высота - 74см.<br /><strong>Аквариум с тумбой</strong>:<br />высота - 124см.</td>
                    <td style="text-align: center;">&nbsp;Мебельный пластик -&nbsp;<br />"дуб".</td>
                    <td style="text-align: center;">&nbsp;30 000р.</td>
                    <td style="text-align: center;">&nbsp;склад</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№4</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/klass02.jpg" alt="" width="106" height="150" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong><span style="color: #333333; font-size: 14px; text-align: center; background-color: #f9f9f9;">"Классика-240"</span></strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>240л&nbsp;<br /><strong>Аквариум</strong>&nbsp;(с крышкой):<br />длина - 1м 2см;<br />ширина - 46см;<br />высота - 74см.<br /><strong>Аквариум с тумбой:</strong><br />высота - 124см.</td>
                    <td style="text-align: center;">&nbsp;Мебельный пластик -&nbsp;<br />"темное дерево".</td>
                    <td style="text-align: center;">&nbsp;30 000р.</td>
                    <td style="text-align: center;">&nbsp;склад</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№5</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/laguna01.jpg" alt="" width="113" height="150" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Лагуна-260"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;260л<br /><strong>Аквариум</strong>&nbsp;(с крышкой):<br />длина - 1м 10см;<br />ширина боковых сторон - 35см;<br />ширина(max) по середине дуги- 46см;<br />высота - 60см.<br /><strong>Аквариум с тумбой:</strong><br />высота - 127см.</td>
                    <td style="text-align: center;">&nbsp;Мебельный пластик -&nbsp;<br />"бук".</td>
                    <td style="text-align: center;">&nbsp;36 000р</td>
                    <td style="text-align: center;">склад&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№6</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/klass300.jpg" alt="Аквариум: Классика-300." width="121" height="160" vspace="7" /><br /><br /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Классика 300 нестандартная"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;300л.<br /><strong>Аквариум</strong>&nbsp;(с крышкой):<br />длина - 1м 30см;<br />ширина - 41см;<br />высота - 65см.<br /><strong>Тумба(трехдверная):</strong><br />высота - 74см.</td>
                    <td style="text-align: center;">&nbsp;Мебельный пластик -&nbsp;<br />"матовый дуб".</td>
                    <td style="text-align: center;">&nbsp;35 000р.</td>
                    <td style="text-align: center;">&nbsp;склад</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№7</span><br />
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: center;"><img class="image-shadow" src="/selloff/lowfoto/klass550.jpg" alt="Аквариум: Классика-550." width="113" height="150" vspace="7" /><img class="image-relative" src="/selloff/lowfoto/struckoff2.gif" alt="" width="118" height="110" /></td>
                </tr>
                </tbody>
            </table>
            <span style="font-size: 14px; background-color: #f9f9f9;">Еще фото:&nbsp;</span><a style="font-size: 14px; background-color: #f9f9f9;" title="Аквариум: Классика-550, 1" href="/selloff/bigfoto/klass550ex2.jpg">&lt;1&gt;</a><span style="font-size: 14px; background-color: #f9f9f9;">,&nbsp;</span><a style="font-size: 14px; background-color: #f9f9f9;" title="Аквариум: Классика-550, 2" href="/selloff/bigfoto/klass550ex3.jpg">&lt;2&gt;</a><span style="font-size: 14px; background-color: #f9f9f9;">.</span></td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Классика 500 нестандартная"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;500л.<br /><strong>Аквариум</strong>&nbsp;(с крышкой):<br />длина - 1м 17см;<br />ширина - 65см;<br />высота - 74см.<br /><strong>Тумба(трехдверная):</strong><br />высота - 75см.</td>
                    <td style="text-align: center;">&nbsp;Мебельный пластик -&nbsp;<br />"темный орех ".</td>
                    <td style="text-align: center;">48 000р.&nbsp;</td>
                    <td style="text-align: center;">&nbsp;склад</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№8</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/klass03.jpg" alt="" width="147" height="135" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Классика 300"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;300л<br /><strong>Аквариум&nbsp;</strong>(с крышкой):<br />длина - 1м;<br />ширина - 40см;<br />высота - 77см.<br />В комплект входит короб для шлангов. Электроотсек выносной.</td>
                    <td style="text-align: center;">&nbsp;Мебельный пластик -&nbsp;<br />"металлик ".</td>
                    <td style="text-align: center;">25 000р.&nbsp;</td>
                    <td style="text-align: center;">склад&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№9</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/aquatlantisevasion.jpg" alt="" width="129" height="135" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
            <br style="font-size: 14px; background-color: #f9f9f9;" /><a style="font-size: 14px; background-color: #f9f9f9;" href="/ferplast/aquatlantis.php" target="_blank">см. &ldquo;Аквариумы AQUATLANTIS&rdquo;</a></td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong><span style="color: #333333; font-size: 14px; text-align: center; background-color: #f9f9f9;">"Aquatlantis Evasion"&nbsp;</span></strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>250л<br /><strong>Аквариум</strong>&nbsp;(с крышкой):<br />длина - 1м 20см;<br />ширина - 40см;<br />высота - 55см.<br /><strong>Тумба:</strong><br />высота - 70см.</td>
                    <td style="text-align: center;">&nbsp;<strong>Крышка</strong>&nbsp;-&nbsp;<br />алюминиевый профиль.&nbsp;<br /><strong>Тумба</strong>&nbsp;-&nbsp;ДСП.</td>
                    <td style="text-align: center;">&nbsp;41 000р.</td>
                    <td style="text-align: center;">офис&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№10</span><br />
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: center;"><br /><img class="image-shadow" src="/selloff/lowfoto/laguna260grey.jpg" alt="Продажа аквариумов: Лагуна170, отделка - серый полистирол." width="109" height="150" vspace="7" /><img class="image-relative" src="/selloff/lowfoto/struckoff2.gif" alt="" width="118" height="110" /></td>
                </tr>
                </tbody>
            </table>
            <span style="font-size: 14px; background-color: #f9f9f9;">Еще фото:&nbsp;</span><a style="font-size: 14px; background-color: #f9f9f9;" title="Продажа аквариумов: Лагуна170, отделка - серый полистирол, 1" href="/selloff/bigfoto/laguna260greyex2.jpg">&lt;1&gt;</a><span style="font-size: 14px; background-color: #f9f9f9;">,&nbsp;</span><a style="font-size: 14px; background-color: #f9f9f9;" title="Продажа аквариумов: Лагуна170, отделка - серый полистирол, 2" href="/selloff/bigfoto/laguna260greyex3.jpg">&lt;2&gt;</a><span style="font-size: 14px; background-color: #f9f9f9;">.</span></td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Лагуна 260"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;260л<br /><strong>Аквариум</strong>&nbsp;(с крышкой):<br />длина - 111см;<br />ширина(max) - 48см;<br />высота - 62см.<br /><strong>Тумба:</strong><br />высота - 65,5см.</td>
                    <td style="text-align: center;">Серый полистирол.&nbsp;</td>
                    <td style="text-align: center;">&nbsp;19 000р.</td>
                    <td style="text-align: center;">&nbsp;зоомагазин<br />Ленинский пр-т, д.123</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№11</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/table.jpg" alt="Столик-лодочка." width="119" height="80" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
            <br style="font-size: 14px; background-color: #f9f9f9;" /><span style="font-size: 14px; background-color: #f9f9f9;">Еще фото:&nbsp;</span><a style="font-size: 14px; background-color: #f9f9f9;" title="Столик-лодочка, 1" href="/selloff/bigfoto/tableex2.jpg">&lt;1&gt;</a><span style="font-size: 14px; background-color: #f9f9f9;">,&nbsp;</span><a style="font-size: 14px; background-color: #f9f9f9;" title="Столик-лодочка, 2" href="/selloff/bigfoto/tableex3.jpg">&lt;2&gt;</a><span style="font-size: 14px; background-color: #f9f9f9;">.</span></td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Столик-лодочка"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;Длина основания:<br />91см<br />Стекло - 140x70см;<br />высота - 60см.<br />В наличии 2 экземпляра.</td>
                    <td style="text-align: center;">&nbsp;Основание и ножки -&nbsp;<br />серебристый металлик.</td>
                    <td style="text-align: center;">10 000р.&nbsp;</td>
                    <td style="text-align: center;">&nbsp;склад</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№12</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><a href="/ferplast/bigfoto/stcayman110silver2.jpg"><img class="image-shadow" src="/selloff/lowfoto/stcayman110silver2.jpg" alt="" width="120" height="98" vspace="7" /></a></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong><span style="color: #414042; font-size: 14px; text-align: center; background-color: #f9f9f9;">Тумба под аквариум&nbsp;</span><span style="font-size: 14px; font-weight: bold; color: #414042; text-align: center; background-color: #f9f9f9;">CAYMAN 110&nbsp;</span><span style="color: #414042; font-size: 14px; text-align: center; background-color: #f9f9f9;">, террариум</span><span style="font-size: 14px; font-weight: bold; color: #414042; text-align: center; background-color: #f9f9f9;">&nbsp;"Explora 110"</span><span style="color: #414042; font-size: 14px; text-align: center; background-color: #f9f9f9;">&nbsp;итальянской компании&nbsp;</span><span style="font-size: 14px; font-weight: bold; color: #414042; text-align: center; background-color: #f9f9f9;">"FERPLAST"</span><span style="color: #414042; font-size: 14px; text-align: center; background-color: #f9f9f9;">.&nbsp;</span></strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>длина - 110см,&nbsp;<br />ширина - 45см,&nbsp;<br />высота - 73см.</td>
                    <td style="text-align: center;">&nbsp;Черный ламинат</td>
                    <td style="text-align: center;">&nbsp;9 440р.</td>
                    <td style="text-align: center;">&nbsp;склад</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">
            <p style="background-color: #f9f9f9;" align="center">№13</p>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/laguna260n04.jpg" alt="Лагуна -260 отделка N04 - светлое дерево" width="127" height="150" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
            &nbsp;</td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>"Лагуна 260"</strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;260л</td>
                    <td style="text-align: center;">&nbsp;Отделка - светлое дерево.</td>
                    <td style="text-align: center;">&nbsp;36 000р.</td>
                    <td style="text-align: center;">склад&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px; background-color: #f9f9f9;">№14</span>
            <table style="font-size: 14px; background-color: #f9f9f9;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/kariba400cherry.jpg" alt="Аквариум - Классика 240, отделка крышки и тумбы - венге." width="103" height="150" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong>Название<span style="color: #333333; font-size: 14px; text-align: center; background-color: #f9f9f9;">"Кариба-400"&nbsp;</span><span style="color: #333333; font-size: 14px; text-align: center; background-color: #f9f9f9;">угловой-дуговой акв.</span></strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td><strong>Аквариум&nbsp;</strong>(с крышкой):<br />катеты - 94 см;<br />высота - 73 см.<br /><strong>Тумба:&nbsp;</strong>высота - 74см.</td>
                    <td style="text-align: center;">&nbsp;Темная вишня</td>
                    <td style="text-align: center;">&nbsp;48 000р.</td>
                    <td style="text-align: center;">&nbsp;склад</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>
<hr class="separator-line" />
<table class="table-padding5" width="100%" cellspacing="0" cellpadding="0">
    <tbody>
    <tr>
        <td style="vertical-align: top; text-align: center; width: 160px;">&nbsp;<span style="color: #414042; font-size: 14px;">№15</span>
            <table style="font-size: 14px;" align="center">
                <tbody>
                <tr>
                    <td style="vertical-align: top; text-align: left;"><img class="image-shadow" src="/selloff/lowfoto/klassglass700.jpg" alt="Аквариум 700л" width="150" height="113" vspace="7" /></td>
                </tr>
                </tbody>
            </table>
        </td>
        <td style="vertical-align: top; text-align: left;">
            <p><strong><span style="color: #333333; font-size: 14px; text-align: center;">"Классика"&nbsp;</span><span style="color: #333333; font-size: 14px; text-align: center;">прямоугольный акв.&nbsp;</span></strong></p>
            <table class="table-img-characters table-padding5">
                <tbody>
                <tr>
                    <th width="30%">Описание</th>
                    <th width="27%">Отделка</th>
                    <th width="15%">Цена</th>
                    <th width="18%">Где находится</th>
                </tr>
                <tr>
                    <td>&nbsp;<span style="font-size: 14px; font-weight: bold; color: #333333; text-align: center;">Аквариум</span><span style="color: #333333; font-size: 14px; text-align: center;">:</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">длина - 208 см;</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">ширина - 50 см;</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">высота - 70 см;.</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">объем - 700л.&nbsp;</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">Без крышки и тумбы (могут быть</span><br style="font-size: 14px; color: #333333; text-align: center;" /><span style="color: #333333; font-size: 14px; text-align: center;">изготовлены дополнительно.)</span></td>
                    <td style="text-align: center;">&nbsp;</td>
                    <td style="text-align: center;">&nbsp;<span style="color: #333333; font-size: 14px;">55 000р.</span></td>
                    <td style="text-align: center;">склад&nbsp;</td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>