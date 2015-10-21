<?php

use yii\grid\GridView;
use yii\helpers\Html;
use app\modules\admin\controllers\VarsController;

$action = VarsController::LIST_NAME;
$this->title = $action;
$this->params['breadcrumbs'] = [
    ['label' => $action]
];

echo Html::a('Добавить', ['add'], ['class' => 'btn btn-primary btn-add']);

if (Yii::$app->session->get('show_vars')) {
    echo Html::a('Показать тексты на сайте', ['switch', 'vars' => 0], ['class' => 'btn btn-default btn-add']);
    echo Html::tag('div', 'Сейчас на сайте отображаются названия переменных', ['class' => 'pull-right text-danger']);
} else {
    echo Html::a('Показать переменные на сайте', ['switch', 'vars' => 1], ['class' => 'btn btn-default btn-add']);
    echo Html::tag('div', 'Сейчас на сайте отображаются тексты', ['class' => 'pull-right text-success']);
}

echo '<div class="clearfix"></div>';

// вывод сообщений если имеются
\app\helpers\MHtml::alertMsg();

echo GridView::widget([
    'dataProvider' => $dataProvider,
    'filterModel' => $searchModel,
    'columns' => [
        [
            'attribute' => 'id',
            'format' => 'text',
            'value' => function($model){
                return sprintf('Msg_%04d', $model->id);
            },
            'headerOptions' => [
                'width' => 80,
                'class' => 'text-center'
            ],
            'contentOptions' => [
                'class' => 'text-center'
            ]
        ],
        [
            'attribute' => 'value',
            'headerOptions' => [
                'class' => 'text-left'
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
                return \app\helpers\ManageList::get($model, [], ['remove']);
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