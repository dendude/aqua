<?php
use yii\helpers\Html;
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
<div class="layout layout-auth">
    <div class="top-actions">
        <div class="top-logo top-logo-auth">
            <a href="<?= Yii::$app->homeUrl ?>">&nbsp;</a>
        </div>
    </div>
    <div class="main-container"><?= $content ?></div>
</div>
<?php $this->endBody() ?>
<div class="layout-gradient"></div>
</body>
</html>
<?php $this->endPage() ?>
