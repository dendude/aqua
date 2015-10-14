<?php
use yii\bootstrap\Nav;
use yii\bootstrap\Dropdown;
use app\helpers\Statuses;
use yii\helpers\Html;
use \app\modules\admin\controllers\PhotosController;

$label_options = ['class' => 'label label-danger pull-right'];

$new_reviews_count = \app\models\Reviews::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_reviews_label = $new_reviews_count ? Html::tag('span', '+ ' . $new_reviews_count, $label_options) : '';

$new_feedback_count = \app\models\Feedback::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_feedback_label = $new_feedback_count ? Html::tag('span', '+ ' . $new_feedback_count, $label_options) : '';

$new_question_count = \app\models\Faq::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_question_label = $new_question_count ? Html::tag('span', '+ ' . $new_question_count, $label_options) : '';

echo Nav::widget([
    'items' => [
        ['label' => 'Главная','url' => ['default/index']],
    ],
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

echo Nav::widget([
    'items' => [
        ['label' => $new_reviews_label . 'Отзывы','url' => ['reviews/list']],
        ['label' => $new_feedback_label . 'Обратная связь','url' => ['feedback/list']],
        ['label' => $new_question_label . 'Вопросы и ответы','url' => ['faq/list']],
        ['label' => 'Пользователи','url' => ['users/list']],
    ],
    'encodeLabels' => false,
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

echo Nav::widget([
    'items' => [
        ['label' => 'Меню','url' => ['menu/list']],
        ['label' => 'Страницы', 'url' => ['pages/list']],
        ['label' => 'Акции', 'url' => ['actions/list']],
        ['label' => 'Новости','url' => ['news/list']],
        ['label' => 'Результаты','url' => ['results/list']],
        ['label' => PhotosController::LIST_NAME,'url' => ['photos/sections']],
        ['label' => 'Видеолекции','url' => ['videos/list']],
    ],
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);


echo Nav::widget([
    'items' => [
        [
            'label' => 'Разделы',
            'linkOptions' => ['class' => 'dropdown-links'],
            'items' => Nav::widget([
                'items' => [
                    ['label' => 'Разделы акций','url' => ['actions/sections']],
                    ['label' => 'Разделы вопросов','url' => ['faq/sections']],
                    ['label' => 'Разделы новостей','url' => ['news/sections']],
                    ['label' => 'Разделы результатов','url' => ['results/sections']],
                    ['label' => PhotosController::LIST_SECTIONS,'url' => ['videos/sections']],
                ],
                'options' => ['class' =>'dropdown-menu'],
            ]),
        ],
    ],
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

if (Yii::$app->user->identity->role == \app\models\Users::ROLE_ADMIN):

echo Nav::widget([
    'items' => [
        ['label' => 'Шаблоны писем','url' => ['mail/templates']],
        ['label' => 'Тексты сайта','url' => ['vars/list']],
        ['label' => 'Карта сайта','url' => ['/site/sitemap'], 'linkOptions' => ['target' => '_blank']],
        ['label' => 'Настройки','url' => ['settings/index']],
    ],
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

endif;