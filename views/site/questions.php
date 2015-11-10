<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="page-content">
    <div class="page-container page-simple">
        <h1 class="page-title"><?= $this->title ?></h1>
    </div>
</div>