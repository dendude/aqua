<?php

use yii\helpers\Html;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use app\models\Menu;
use yii\helpers\Url;
use app\helpers\Normalize;
use app\models\Pages;
use \app\models\Users;
use app\components\ReCaptcha;

AppAsset::register($this);

$top_menu1 = Menu::find()->active()->top1()->all();
$top_menu2 = Menu::find()->active()->top2()->all();
$top_menu3 = Menu::find()->active()->top3()->all();

$footer_menu = Menu::find()->active()->footer()->all();

?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>"/>
        <meta name="viewport" content="width=device-width, initial-scale=1"/>
        <meta name="format-detection" content="telephone=no"/>
        <link href="/favicon.ico?2" rel="shortcut icon" type="image/x-icon"/>

        <title><?= Html::encode(!empty($this->params['meta_t']) ? $this->params['meta_t'] : $this->title) ?></title>
        <? if (!empty($this->params['meta_d'])): ?><meta name="description" content="<?= Html::encode($this->params['meta_d']) ?>"/><? endif; ?>
        <? if (!empty($this->params['meta_k'])): ?><meta name="keywords" content="<?= Html::encode($this->params['meta_k']) ?>"/><? endif; ?>
    
        <?= Html::csrfMetaTags() ?>
        <?php $this->head() ?>
    
        <script src="https://www.google.com/recaptcha/api.js?onload=onloadCallback&render=explicit" async="async" defer="defer"></script>
        <script type="text/javascript">
            var onloadCallback = function() {
                grecaptcha.render('widget_ca_question', {'sitekey' : '<?= ReCaptcha::PUBLIC_KEY ?>'});
                grecaptcha.render('widget_ca_free_travel', {'sitekey' : '<?= ReCaptcha::PUBLIC_KEY ?>'});
                grecaptcha.render('widget_ca_calculate', {'sitekey' : '<?= ReCaptcha::PUBLIC_KEY ?>'});
                grecaptcha.render('widget_ca_callback', {'sitekey' : '<?= ReCaptcha::PUBLIC_KEY ?>'});
                grecaptcha.render('widget_ca_review', {'sitekey' : '<?= ReCaptcha::PUBLIC_KEY ?>'});
            }
        </script>
    </head>
    <body>
    <?php $this->beginBody() ?>

    <div class="layout">
        <nav class="top-nav">
            <div class="top-container">
                <form class="top-search" action="<?= Url::to([Normalize::fixAlias(Pages::SEARCH_ID)]) ?>">
                    <div class="input-search">
                        <input name="q" type="text" placeholder="<?= Yii::$app->vars->val(78, true) ?>" value="<?= Yii::$app->request->get('q','') ?>" />
                    </div>
                    <button>
                        <i class="glyphicon glyphicon-search"></i>
                    </button>
                </form>
                <div class="top-info">
                    <span class="top-contacts">
                        <?= Yii::$app->vars->val(1) ?><br/>
                        <small><?= Yii::$app->vars->val(2) ?></small>
                    </span>
                    <? if ($top_menu1): ?>
                    <ul class="top-menu">
                        <? foreach ($top_menu1 AS $mk => $menu_item): ?>
                            <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                            <li><a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a></li>
                            <? if (($mk+1) < count($top_menu1) || Users::isManager()): ?><li>|</li><? endif; ?>
                        <? endforeach; ?>
                        <? if (Users::isAdmin()): ?>
                            <li><a href="<?= Url::to(['admin/pages/list']) ?>">Admin</a></li>
                        <? elseif (Users::isManager()): ?>
                            <li><a href="<?= Url::to(['admin/pages/list']) ?>">Manager</a></li>
                        <? endif; ?>
                    </ul>
                    <? endif; ?>
                </div>
                <button class="bnt-bar" onclick="$('body').toggleClass('sidebar-opened')">
                    <i class="fa fa-bars"></i>
                </button>
            </div>
            <ul class="top-sidebar">
                <? if ($top_menu3): ?>
                    <? foreach ($top_menu3 AS $menu_item): ?>
                        <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                        <li>
                            <a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a>
                            <? if ($menu_item->childs): ?>
                                <ul>
                                    <? foreach ($menu_item->childs AS $submenu_item): ?>
                                        <? if ($submenu_item->status != \app\helpers\Statuses::STATUS_ACTIVE) continue; ?>
                                        <? $link = $submenu_item->page ? Url::to([Normalize::fixAlias($submenu_item->page->alias)]) : '#'; ?>
                                        <li><a href="<?= $link ?>"><?= Html::encode($submenu_item->menu_name) ?></a></li>
                                    <? endforeach; ?>
                                </ul>
                            <? endif; ?>
                        </li>
                    <? endforeach; ?>
                <? endif; ?>
            </ul>
        </nav>

        <div class="top-actions">
            <div class="top-logo">
                <a href="<?= Yii::$app->homeUrl ?>">&nbsp;</a>
            </div>
            <div class="top-words">
                <div class="cell"><?= Yii::$app->vars->val(79) ?></div>
            </div>
            <div class="top-buttons">
            <? if ($top_menu2): ?>
                <? foreach ($top_menu2 AS $menu_item): ?>
                    <a class="top-acts top-act-<?= $menu_item->id ?>" data-target="#modal_form_<?= $menu_item->id ?>" data-toggle="modal">
                        <?= $menu_item->menu_name ?>
                        <i></i>
                    </a>
                <? endforeach; ?>
            <? endif; ?>
            </div>
        </div>

        <nav class="navbar-main <? if (!in_array(Yii::$app->request->url, ['/', '/index' . Yii::$app->urlManager->suffix], true)): ?>navbar-simple<? endif; ?>">
            <ul>
            <? if ($top_menu3): ?>
                <? foreach ($top_menu3 AS $menu_item): ?>
                    <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                    <li>
                        <a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a>
                        <? if ($menu_item->childs): ?>
                            <ul>
                            <? foreach ($menu_item->childs AS $submenu_item): ?>
                                <? if ($submenu_item->status != \app\helpers\Statuses::STATUS_ACTIVE) continue; ?>
                                <? $link = $submenu_item->page ? Url::to([Normalize::fixAlias($submenu_item->page->alias)]) : '#'; ?>
                                <li><a href="<?= $link ?>"><?= Html::encode($submenu_item->menu_name) ?></a></li>
                            <? endforeach; ?>
                            </ul>
                        <? endif; ?>
                    </li>
                <? endforeach; ?>
            <? endif; ?>
            </ul>
        </nav>

        <? if (!empty($this->params['banner_name'])): ?>
            <? $banner_model = \app\models\Photos::find()->where(['img_big' => $this->params['banner_name']])->one() ?>
            <div class="top-banner">
                <span class="top-banner-inner">
                    <? if (!empty($banner_model->page_id)): ?><a href="<?= Url::to([Normalize::fixAlias($banner_model->page_id)]) ?>"><? endif; ?>
                        <?= Html::img(\app\models\forms\UploadForm::getSrc($this->params['banner_name'], \app\models\forms\UploadForm::TYPE_GALLERY), ['alt' => $banner_model->title]) ?>
                    <? if (!empty($banner_model->page_id)): ?></a><? endif; ?>
                </span>
            </div>
        <? endif; ?>

        <div class="main-container">
            <?= Breadcrumbs::widget([
                'homeLink' => ['url' => Yii::$app->homeUrl, 'label' => Yii::$app->vars->val(100)],
                'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
            ]) ?>
            <?= $content ?>
        </div>
    </div>

    <footer class="footer">
        <? if ($footer_menu): ?>
            <ul class="footer-menu">
                <? foreach ($footer_menu AS $mk => $menu_item): ?>
                    <? $link = $menu_item->page ? Url::to([Normalize::fixAlias($menu_item->page->alias)]) : '#'; ?>
                    <li><a href="<?= $link ?>"><?= Html::encode($menu_item->menu_name) ?></a></li>
                    <? if (($mk+1) < count($footer_menu)): ?><li>|</li><? endif; ?>
                <? endforeach; ?>
            </ul>
        <? endif; ?>
        <div class="footer-container" style="position:relative">
		<?= Yii::$app->vars->val(80) ?>
		<div style="position: absolute; top: 18px; left: 0;" class="hidden-xs">
			<!-- Yandex.Metrika counter -->
			<script type="text/javascript">
			(function (d, w, c) {
			(w[c] = w[c] || []).push(function() {
		        try {
		            w.yaCounter23991331 = new Ya.Metrika({id:23991331,
                	    webvisor:true,
	                    clickmap:true,
        	            trackLinks:true,
                	    accurateTrackBounce:true});
		        } catch(e) { }
		    });

		    var n = d.getElementsByTagName("script")[0],
		        s = d.createElement("script"),
		        f = function () { n.parentNode.insertBefore(s, n); };
		    s.type = "text/javascript";
		    s.async = true;
		    s.src = (d.location.protocol == "https:" ? "https:" : "http:") + "//mc.yandex.ru/metrika/watch.js";

		    if (w.opera == "[object Opera]") {
		        d.addEventListener("DOMContentLoaded", f, false);
		    } else { f(); }
		})(document, window, "yandex_metrika_callbacks");
		</script>

		<noscript><div><img src="//mc.yandex.ru/watch/23991331" style="position:absolute; left:-9999px;" alt="" /></div></noscript>
		<!-- /Yandex.Metrika counter -->
        <script>
            document.write("<a href='http://www.liveinternet.ru/click' "+
                "target=_blank><img src='//counter.yadro.ru/hit?t38.12;r"+
                escape(document.referrer)+((typeof(screen)=="undefined")?"":
                    ";s"+screen.width+"*"+screen.height+"*"+(screen.colorDepth?
                    screen.colorDepth:screen.pixelDepth))+";u"+escape(document.URL)+
                ";h"+escape(document.title.substring(0,80))+";"+Math.random()+
                "' alt='' title='LiveInternet' "+
                "border='0' width='31' height='31'><\/a>");
        </script>
	</div>
    </footer>

    <noindex>
        <div class="layout-gradient"></div>
        <?= \app\widgets\ModalForms::widget(); ?>
    </noindex>

    <?php $this->endBody() ?>

    <input type="hidden" id="page_order_aqua" value="<?= Url::to([Normalize::fixAlias(Pages::ORDER_ID_AQUA)]) ?>" />
    <input type="hidden" id="page_order_services" value="<?= Url::to([Normalize::fixAlias(Pages::ORDER_ID_SERVICES)]) ?>" />

<div>

    </body>
    </html>
<?php $this->endPage() ?>
