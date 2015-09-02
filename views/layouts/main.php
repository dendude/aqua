<?php

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">
    <nav class="navbar-top navbar">
        <div class="container">
            <div class="collapse navbar-collapse">
                <ul class="navbar-nav navbar-right nav">
                    <li>
                        <span>
                            +7(495) 755-7874,  (495) 921-5206 <br/>
                            <small>г. Москва, ул. Енисейская, 1, оф. 32</small>
                        </span>
                    </li>
                </ul>
                <ul class="navbar-nav navbar-right nav">
                    <li><a href="#">О компании</a></li>
                    <li><a href="#">Контакты</a></li>
                    <li><a href="#">Вопрос-ответ</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="top-actions">
        <div class="top-logo">
            <a href="<?= Yii::$app->homeUrl ?>"><img src="/img/logo.png" alt=""/></a>
        </div>
        <div class="top-words">
            Собственное производство!<br/>20 лет на рынке!
        </div>
        <div class="top-search">
            <input type="text" placeholder="Поиск по сайту"/>
            <button>
                <i class="glyphicon glyphicon-search"></i>
            </button>
        </div>
        <div class="top-buttons">
            <a class="top-acts act-specialist" href="#">Бесплатный<br/>выезд<br/>специалиста</a>
            <a class="top-acts act-counting" href="#">Расчитать<br/>стоимость<br/>аквариума</a>
            <a class="top-acts act-callback" href="#">Заказать<br/>обратный<br/>звонок</a>
        </div>
        <div class="clearfix"></div>
    </div>

    <nav class="navbar-main">
        <table>
            <tr>
                <td><a href="#">Изготовление аквариумов</a></td>
                <td><a href="#">Оформление и обслуживание</a></td>
                <td><a href="#">Наше производство</a></td>
                <td><a href="#">Цены</a></td>
                <td><a href="#">Полезная информация</a></td>
            </tr>
        </table>
    </nav>

    <div class="container">
        <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="footer-container">
        Компания «Альфаро» <br/>
        г. Москва, ул. Енисейская, 1, оф. 32<br/>
        тел./факс (495) 755-7874, (985) 921-5206<br/>
        e-mal: alfaro@alfaro.ru
    </div>
</footer>

<?php $this->endBody() ?>

<div class="layout-gradient"></div>
</body>
</html>
<?php $this->endPage() ?>
