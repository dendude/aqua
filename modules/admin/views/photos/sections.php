<?php

use yii\helpers\Html;
use app\modules\admin\controllers\PhotosController;
use app\helpers\Statuses;
use yii\helpers\Url;
use app\models\forms\UploadForm;

$action = PhotosController::LIST_NAME;
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => $action]
];

/*echo Html::a('Добавить альбом', ['section-add'], ['class' => 'btn btn-primary btn-add']);
*/
echo '<div class="clearfix"></div>';

// вывод сообщений если имеются
\app\helpers\MHtml::alertMsg();

if (!empty($albums)) {

    foreach ($albums AS $album) {
?>
        <div class="photo-album">
            <span class="album-images">
                <? if ($album->photos): ?>
                    <? foreach ($album->photos AS $pk => $photo): ?>
                        <? if ($pk <= 2): ?>
                            <span class="album-photo-item">
                                <img src="<?= UploadForm::getSrc($photo->img_small, UploadForm::TYPE_GALLERY) ?>" alt=""/>
                            </span>
                        <? endif; ?>
                    <? endforeach; ?>
                <? else: ?>
                    <span class="album-empty">
                        <span class="empty-msg">В этом альбоме пока нет фотографий</span>
                        <a class="btn btn-xs btn-primary" href="<?= Url::to(['add', 'section' => $album->id]) ?>">
                            Добавить фотографии
                        </a>
                    </span>
                <? endif; ?>
            </span>
            <span class="album-title"><?= $album->name ?></span>
            <span class="album-status"><?= Statuses::getFull($album->status) ?></span>
            <span class="album-ordering">Порядок: <strong><?= $album->ordering ?></strong></span>
            <span class="album-actions">
                <a class="btn btn-sm btn-success" href="<?= Url::to(['list', 'id' => $album->id]) ?>" title="Фотографии альбома">
                    <i class="glyphicon glyphicon-search"></i>
                </a>
                <a class="btn btn-sm btn-info" href="<?= Url::to(['section-edit', 'id' => $album->id]) ?>" title="Редактировать альбом">
                    <i class="glyphicon glyphicon-pencil"></i>
                </a>
                <!--<a class="btn btn-sm btn-danger" href="<?/*= Url::to(['section-delete', 'id' => $album->id]) */?>" title="Удалить альбом">
                    <i class="glyphicon glyphicon-trash"></i>
                </a>-->
            </span>
        </div>
<?
    }

    echo yii\widgets\LinkPager::widget(['pagination' => $pages, 'hideOnSinglePage' => true]);
} else {
    echo Html::tag('div', 'Альбомы не найдены', ['class' => 'alert alert-info']);
}