<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;

$this->title = $model->title;
$this->params['breadcrumbs'][] = $this->title;
$this->params['banner_name'] = $model->banner_name;