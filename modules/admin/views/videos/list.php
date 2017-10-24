<?php
use yii\helpers\Html;
use app\modules\admin\controllers\VideosController;
use yii\helpers\Url;
use app\helpers\Statuses;

/**
 * @var $videos \app\models\Videos[]
 * @var $pages \yii\data\Pagination
 */

$this->title = VideosController::LIST_NAME;
$this->params['breadcrumbs'] = [
    ['label' => VideosController::LIST_NAME, 'url' => ['sections']],
    ['label' => $this->title]
];
?>

<?= Html::a('Добавить видеозапись', ['add'], ['class' => 'btn btn-primary btn-add']); ?>
<div class="clearfix"></div>
<? \app\helpers\MHtml::alertMsg(); ?>

<? if (!empty($videos)): ?>
    <div class="videos-container">
        <? foreach ($videos AS $vm): ?>
        <div class="video-item">
            <div class="video-item__preview">
                <?= Html::img($vm->preview_url) ?>
                <div class="video-item__status"><?= Statuses::getFull($vm->status) ?></div>
            </div>
            <div class="video-item__content">
                <div class="video-item__ordering">Порядок: <?= $vm->ordering ?></div>
                <div class="video-item__title text-muted"><?= Html::encode($vm->title) ?></div>
                <div class="video-item__actions">
                    <div class="btn-group btn-group-justified">
                        <div class="btn-group">
                            <a class="btn btn-sm btn-success" href="<?= $vm->video_url ?>" title="Просмотр видео" target="_blank">
                                <i class="glyphicon glyphicon-search"></i>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-info" href="<?= Url::to(['edit', 'id' => $vm->id]) ?>" title="Редактировать видео">
                                <i class="glyphicon glyphicon-pencil"></i>
                            </a>
                        </div>
                        <div class="btn-group">
                            <a class="btn btn-sm btn-danger" href="<?= Url::to(['delete', 'id' => $vm->id]) ?>" title="Удалить видео">
                                <i class="glyphicon glyphicon-trash"></i>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <? endforeach; ?>
    </div>
    <?= yii\widgets\LinkPager::widget(['pagination' => $pages, 'hideOnSinglePage' => true]); ?>
<? else: ?>
    <?= Html::tag('div', 'Видеозаписи не найдены', ['class' => 'alert alert-info']); ?>
<? endif; ?>
