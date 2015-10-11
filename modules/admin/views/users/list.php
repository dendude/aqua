<?php

use yii\grid\GridView;
use yii\helpers\Html;
use app\modules\admin\controllers\UsersController;

$action = UsersController::LIST_NAME;
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
            'attribute' => 'role',
            'format' => 'raw',
            'filter' => \app\models\Users::getRolesNames(),
            'value' => function($model){
                return $model->getRoleName();
            },
            'headerOptions' => [
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'name',
            'headerOptions' => [
                'class' => 'text-left'
            ],
        ],
        [
            'attribute' => 'email',
            'contentOptions' => [
                'class' => 'text-center'
            ],
        ],
        [
            'attribute' => 'phone',
            'contentOptions' => [
                'class' => 'text-center'
            ],
            'value' => function($model){
                return \app\helpers\Normalize::formatPhone($model->phone);
            },
        ],
        [
            'attribute' => 'status',
            'format' => 'html',
            'value' => function($model){
                return \app\helpers\Statuses::getFull($model->status, \app\helpers\Statuses::TYPE_ACTIVE);
            },
            'filter' => \app\helpers\Statuses::statuses(\app\helpers\Statuses::TYPE_ACTIVE),
            'headerOptions' => [
                'width' => 100,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
        ],
        [
            'attribute' => 'last_visit',
            'format' => 'html',
            'filter' => false,
            'value' => function($model){
                return \app\helpers\Normalize::getFullDateByTime($model->last_visit, '<br/>');
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