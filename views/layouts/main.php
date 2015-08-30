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
                            +7 (495) 123-45-78, +7 (495) 123-45-78<br/>
                            <small>г.Москва, Енисейская область, дом 7 кв 56</small>
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

    <div class="top-actions"></div>

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
    <div class="footer-container"></div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
