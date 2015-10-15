<?php

$this->title = $model->title;
$this->params['meta_t'] = $model->meta_t;
$this->params['meta_d'] = $model->meta_d;
$this->params['meta_k'] = $model->meta_k;
$this->params['breadcrumbs'] = $model->getBreadcrumbs();

?>
<div class="site-page">
    <div class="page-content page-auto transparent"><?= $content ?></div>
    <?= \app\widgets\MainWidgets::widget() ?>
    <div class="clearfix"></div>
</div>