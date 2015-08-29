<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'modules' => [
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
    ],
    'components' => [
        'request' => [
            // !!! insert a secret key in the following (if it is empty) - this is required by cookie validation
            'cookieValidationKey' => '98reherhOHe7UHFy64JKNngth3g0e9w',
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\User',
            'enableAutoLogin' => true,
        ],
        'session' => [
            //'class' => 'yii\web\DbSession',
            'useCookies' => true,
            'timeout' => 3600*24*30,
            'cookieParams' => [
                'httpOnly' => true,
                //'secure' => true,
                //'lifetime' => (time() + 3600*24*100),
            ]
        ],
        'urlManager' => [
            'class' => 'yii\web\UrlManager',
            'suffix' => '.html',
            'enablePrettyUrl' => true,
            'showScriptName' => false,
            'rules' => [
                '' => 'site/index',

                '<action:[\w\-]+>/<id:\d+>' => 'site/<action>',
                '<action:[\w\-]+>' => 'site/<action>',

                '<controller:[\w\-]+>/<action:>/<id:\d+>' => '<controller>/<action>',
                '<controller:[\w\-]+>/<action:>' => '<controller>/<action>',

                '<module:[\w\-]+>/<controller:[\w\-]+>/<action:>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:[\w\-]+>/<controller:[\w\-]+>/<action:>' => '<module>/<controller>/<action>',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'mailer' => [
            'class' => 'yii\swiftmailer\Mailer',
            // send all mails to a file by default. You have to set
            // 'useFileTransport' to false and configure a transport
            // for the mailer to send real emails.
            'useFileTransport' => true,
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
            ],
        ],
        'db' => require(__DIR__ . '/db.php'),
    ],
    'params' => $params,
];

if (YII_ENV_DEV) {
    // configuration adjustments for 'dev' environment
    $config['bootstrap'][] = 'debug';
    $config['modules']['debug'] = 'yii\debug\Module';

    $config['bootstrap'][] = 'gii';
    $config['modules']['gii'] = 'yii\gii\Module';
}

\Yii::$container->set('yii\grid\GridView', [
    'layout' => '<div class="grid-summary">{summary}</div>{items}<div class="grid-pagination">{pager}</div>',
    'summary' => 'Записи <strong>{begin}</strong>-<strong>{end}</strong> из <strong>{totalCount}</strong>',
    'pager' => [
        'firstPageLabel' => 'Первая',
        'nextPageLabel' => '&rarr;',
        'prevPageLabel' => '&larr;',
        'lastPageLabel' => 'Последняя'
    ],
    'emptyText' => 'Записи не найдены',
    'emptyTextOptions' => ['class' => 'text-center'],
    'tableOptions' => ['class' => 'table table-striped table-hover table-bordered table-condensed'],
    'filterRowOptions' => ['class' => 'form-group-sm row-filters'],
]);

\Yii::$container->set('yii\widgets\ActiveForm', [
    'enableClientValidation' => false,
    'enableAjaxValidation' => false,
    'enableClientScript' => false,
    'options' => [
        'class' => 'form-horizontal',
    ],
    'fieldConfig' => [
        'template' => '<div class="col-xs-4 text-right">{label}</div><div class="col-xs-8">{input}{error}</div>'
    ],
]);

\Yii::$container->set('yii\validators\RequiredValidator', [
    'message' => 'Обязательно для заполнения',
]);

\Yii::$container->set('yii\validators\StringValidator', [
    'tooShort' => 'Введите не менее {min} символов',
]);

\Yii::$container->set('yii\validators\StringValidator', [
    'tooLong' => 'Введите не более {max} символов',
]);

return $config;
