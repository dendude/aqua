<?php
use yii\helpers\Html;
use app\modules\admin\controllers\PhotosController;
use app\models\forms\UploadForm;
use yii\helpers\Url;
use app\helpers\Statuses;

$this->title = $album->name;
$this->params['breadcrumbs'] = [
    ['label' => PhotosController::LIST_NAME, 'url' => ['sections']],
    ['label' => $this->title]
];

echo Html::a('Добавить фотографии в альбом', ['add', 'id' => $album->id], ['class' => 'btn btn-primary btn-add']);
echo '<div class="clearfix"></div>';

// вывод сообщений если имеются
\app\helpers\MHtml::alertMsg();

if (isset($photos)) {

    if (!empty($photos)) {

        foreach ($photos AS $photo) {
?>
            <div class="photo-item">
                <span class="photo-image">
                    <span class="photo-cont">
                        <?= Html::img(UploadForm::getSrc($photo->img_small, UploadForm::TYPE_GALLERY)) ?>
                    </span>
                </span>
                <span class="photo-title"><?= Html::encode($photo->title) ?></span>
                <span class="photo-about"><?= nl2br(Html::encode($photo->about)) ?></span>
                <span class="photo-ordering">Порядок: <strong><?= $photo->ordering ?></strong></span>
                <span class="photo-status"><?= Statuses::getFull($photo->status) ?></span>
                <span class="photo-actions">
                    <a class="btn btn-sm btn-success" href="<?= UploadForm::getSrc($photo->img_big, UploadForm::TYPE_GALLERY) ?>" title="Просмотр фотографии" target="_blank">
                        <i class="glyphicon glyphicon-search"></i>
                    </a>
                    <a class="btn btn-sm btn-info" href="<?= Url::to(['edit', 'id' => $photo->id]) ?>" title="Редактировать фото">
                        <i class="glyphicon glyphicon-pencil"></i>
                    </a>
                    <a class="btn btn-sm btn-danger" href="<?= Url::to(['delete', 'id' => $photo->id]) ?>" title="Удалить фото">
                        <i class="glyphicon glyphicon-trash"></i>
                    </a>
                </span>
            </div>
<?
        }

        echo '<div class="clearfix"></div>';
        echo yii\widgets\LinkPager::widget(['pagination' => $pages, 'hideOnSinglePage' => true]);
    } else {
        echo Html::tag('div', 'Фотографии в альбоме не найдены', ['class' => 'col-xs-12 col-lg-6 alert alert-info']);
    }
}