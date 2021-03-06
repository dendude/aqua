<?php

use yii\grid\GridView;
use yii\helpers\Html;
use \app\modules\admin\controllers\ReviewsController;
use app\helpers\Statuses;
use app\models\forms\UploadForm;

$action = ReviewsController::LIST_NAME;
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
            'attribute' => 'img_name',
            'format' => 'html',
            'value' => function($model){
                $img_name = $model->img_name ? UploadForm::getSrc($model->img_name, UploadForm::TYPE_REVIEWS, '_min') : \app\models\Reviews::DEFAULT_FISH;
                return Html::img($img_name, ['class' => 'img-cell']);
            },
            'headerOptions' => [
                'class' => 'text-center',
                'width' => 60,
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'manager_id',
            'format' => 'text',
            'filter' => \app\models\Users::getManagers(),
            'value' => function($model){
                return $model->manager_id ? $model->manager->name : '';
            },
            'headerOptions' => [
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'label' => 'Имя',
            'attribute' => 'name',
            'headerOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'attribute' => 'email',
            'headerOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'attribute' => 'comment',
            'headerOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'attribute' => 'ordering',
            'headerOptions' => [
                'width' => 100,
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'status',
            'format' => 'html',
            'value' => function($model){
                return Statuses::getFull($model->status);
            },
            'filter' => Statuses::statuses(),
            'headerOptions' => [
                'width' => 100,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
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
            'header' => 'Действия',
            'format' => 'raw',
            'value' => function($model) {
                return \app\helpers\ManageList::get($model);
            },
            'headerOptions' => [
                'width' => 80,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
        ]
    ],
]);