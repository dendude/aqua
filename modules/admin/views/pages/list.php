<?php

use yii\grid\GridView;
use yii\helpers\Html;
use app\modules\admin\controllers\PagesController;
use app\helpers\Statuses;

$action = PagesController::LIST_NAME;
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => $action]
];

echo Html::a('Добавить', ['add'], ['class' => 'btn btn-primary btn-add']);
echo '<div class="clearfix"></div>';

// вывод сообщений если имеются
\app\helpers\MHtml::alertMsg();

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'format' => 'integer',
            'headerOptions' => [
                'width' => 80,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
        ],
        [
            'attribute' => 'id_author',
            'format' => 'text',
            'filter' => \app\models\Users::getManagers(),
            'value' => function($model){
                return $model->author ? $model->author->name : 'не найден';
            },
            'headerOptions' => [
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'title',
            'headerOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'attribute' => 'alias',
            'headerOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'attribute' => 'menu_id',
            'contentOptions' => [
                'class' => 'text-center'
            ],
            'format' => 'raw',
            'filter' => Statuses::statuses(Statuses::TYPE_YESNO),
            'value' => function($model){
                return Statuses::getFull((bool)$model->menu_id, Statuses::TYPE_YESNO);
            },
        ],
        [
            'attribute' => 'is_shared',
            'filter' => Statuses::statuses(Statuses::TYPE_YESNO),
            'value' => function($model){
                return Statuses::getFull($model->is_shared, Statuses::TYPE_YESNO);
            },
            'format' => 'raw',
            'headerOptions' => [
                'width' => 80,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'is_auto',
            'filter' => Statuses::statuses(Statuses::TYPE_YESNO),
            'value' => function($model){
                return Statuses::getFull($model->is_auto, Statuses::TYPE_YESNO);
            },
            'format' => 'raw',
            'headerOptions' => [
                'width' => 80,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'is_sitemap',
            'filter' => Statuses::statuses(Statuses::TYPE_YESNO),
            'value' => function($model){
                return Statuses::getFull($model->is_sitemap, Statuses::TYPE_YESNO);
            },
            'format' => 'raw',
            'headerOptions' => [
                'width' => 80,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'created',
            'format' => 'html',
            'filter' => false,
            'value' => function($model){
                return \app\helpers\Normalize::getFullDateByTime($model->created, '<br/>');
            },
            'headerOptions' => [
                'width' => 120,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
        ],
        [
            'attribute' => 'modified',
            'format' => 'html',
            'filter' => false,
            'value' => function($model){
                return \app\helpers\Normalize::getFullDateByTime($model->modified, '<br/>');
            },
            'headerOptions' => [
                'width' => 120,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
        ],
        [
            'header' => 'Действия',
            'format' => 'raw',
            'value' => function($model) {
                return \app\helpers\ManageList::get($model, ['show']);
            },
            'headerOptions' => [
                'width' => 120,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
        ]
    ],
]);