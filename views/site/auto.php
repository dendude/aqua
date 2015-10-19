<?php

$this->title = $model->title;
$this->params['meta_t'] = $model->meta_t;
$this->params['meta_d'] = $model->meta_d;
$this->params['meta_k'] = $model->meta_k;
$this->params['breadcrumbs'] = $model->getBreadcrumbs();

$content = '';

?>
<div class="page-content">
    <div class="page-container page-simple">
        <h1 class="page-title"><?= $model->title ?></h1>
        <?= $content ?>
    </div>
</div>