<?php

$params = require(__DIR__ . '/params.php');

$config = [
    'id' => 'basic',
    'name' => 'Alfaro',
    'basePath' => dirname(__DIR__),
    'bootstrap' => ['log'],
    'language' => 'ru',
    'modules' => [
        'manager' => [
            'class' => 'app\modules\manager\ManagerModule',
        ],
        'admin' => [
            'class' => 'app\modules\admin\AdminModule',
        ],
    ],
    'components' => [
        'assetManager' => [
            'linkAssets' => true,
        ],
        'request' => [
            'cookieValidationKey' => 'ewrgn349gb34go93bgio39gblo3i4geigkn',
            'enableCookieValidation' => true,
            'enableCsrfCookie' => true,
            'enableCsrfValidation' => true,
        ],
        'cache' => [
            'class' => 'yii\caching\FileCache',
        ],
        'user' => [
            'identityClass' => 'app\models\Users',
            'enableAutoLogin' => true,
        ],
        'vars' => [
            'class' => '\app\models\Vars',
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
            'enableStrictParsing' => true,
            'rules' => [
                [
                    'pattern' => 'sitemap',
                    'route' => 'site/sitemap',
                    'suffix' => '.xml',
                ],
		[
                    'pattern' => '<alias:[\w\-\/]+>',
                    'route' => 'site/page',
                    'suffix' => '.php',
                ],

                '' => 'site/index',
                'index' => 'site/index',

                '<controller:(ajax|auth)>/<action:>/<id:\d+>' => '<controller>/<action>',
                '<controller:(ajax|auth)>/<action:>' => '<controller>/<action>',

                '<module:(admin|manager)>/<controller:[\w\-]+>/<action:>/<id:\d+>' => '<module>/<controller>/<action>',
                '<module:(admin|manager)>/<controller:[\w\-]+>/<action:>' => '<module>/<controller>/<action>',

                '<action:(free-travel|calculate|callback|question-add)>' => 'site/<action>',

                'album/<id:[\w\-\/]+>' => 'site/album',
                'answer/<id:[\w\-\/]+>' => 'site/answer',

                '<alias:[\w\-\/]+>/<id:\d+>' => 'site/page',
                '<alias:[\w\-\/]+>' => 'site/page',
            ],
        ],
        'errorHandler' => [
            'errorAction' => 'site/error',
        ],
        'log' => [
            'traceLevel' => YII_DEBUG ? 3 : 0,
            'targets' => [
                [
                    'class' => 'yii\log\FileTarget',
                    'levels' => ['error', 'warning'],
                ],
                [
                    'class' => 'yii\log\EmailTarget',
                    'levels' => ['error', 'warning'],
                    'except' => [
                        'yii\web\HttpException:404',
                        'yii\web\HttpException:400',
                        'yii\debug\*',
                    ],
                    'message' => [
                        'from' => ['error@akvarium-moskva.ru' => 'Alfaro'],
                        'to' => [$params['adminEmail']],
                        'subject' => 'Site error',
                    ],
                    'logVars' => ['_SERVER'],
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
    $config['modules']['gii'] = ['class' => 'yii\gii\Module',
                                 'allowedIPs' => ['::1','127.0.0.1','94.19.219.69']];
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
    'message' => 'Поле «{attribute}» обязательно для заполнения',
]);

\Yii::$container->set('yii\validators\EmailValidator', [
    'message' => '«{attribute}» содержит некорректное значение',
]);

\Yii::$container->set('yii\validators\StringValidator', [
    'tooShort' => 'Введите не менее {min} символов',
]);

\Yii::$container->set('yii\validators\StringValidator', [
    'tooLong' => 'Введите не более {max} символов',
]);

\Yii::$container->set('yii\validators\UniqueValidator', [
    'message' => 'Такой {attribute} уже существует',
]);

return $config;
