<?php

/* @var $this yii\web\View */
/* @var $name string */
/* @var $message string */
/* @var $exception Exception */

use yii\helpers\Html;

if ($exception instanceof HttpException) {
    $code = $exception->statusCode;
} else {
    $code = $exception->getCode();
}

$this->title = $code == 404 ? 'Страница не найдена' : 'Ошибка ' . $code;
?>
<div class="site-error">
    <? if ($code == 404): ?>
        <div class="text-center">
            <img src="/img/404.jpg" alt="">
        </div>
    <? else: ?>
        <h1><?= Html::encode($this->title) ?></h1>
        <div class="alert alert-danger">
            <?= nl2br(Html::encode($message)) ?>
        </div>
    <? endif; ?>
</div>
