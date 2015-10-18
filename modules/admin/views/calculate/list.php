<?php

use yii\grid\GridView;
use yii\helpers\Html;
use \app\modules\admin\controllers\CalculateController;
use app\helpers\Statuses;

$action = CalculateController::LIST_NAME;
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
            'attribute' => 'phone',
            'contentOptions' => [
                'class' => 'text-center'
            ],
            'value' => function($model){
                return \app\helpers\Normalize::formatPhone($model->phone);
            },
        ],
        [
            'attribute' => 'message',
            'headerOptions' => [
                'class' => 'text-left'
            ],
            'value' => function($model){
                return mb_substr($model->phone, 0, 550, Yii::$app->charset) . ' ...';
            },
        ],
        [
            'attribute' => 'status',
            'format' => 'html',
            'value' => function($model){
                return Statuses::getFull($model->status, Statuses::TYPE_FEEDBACK);
            },
            'filter' => Statuses::statuses(Statuses::TYPE_FEEDBACK),
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
            'attribute' => 'answered',
            'format' => 'html',
            'filter' => false,
            'value' => function($model){
                return \app\helpers\Normalize::getFullDateByTime($model->answered, '<br/>');
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