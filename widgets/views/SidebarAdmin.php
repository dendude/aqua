<?php
use yii\bootstrap\Nav;
use app\helpers\Statuses;
use yii\helpers\Html;
use \app\modules\admin\controllers\PhotosController;

use app\modules\admin\controllers\FreeTravelController;
use app\modules\admin\controllers\CallbackController;
use app\modules\admin\controllers\CalculateController;
use app\modules\admin\controllers\OrdersController;
use app\modules\admin\controllers\ReviewsController;

$label_options = ['class' => 'label label-success pull-right', 'style' => 'font-size: 12px; line-height: 14px;'];

$new_orders_count = \app\models\Orders::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_orders_label = $new_orders_count ? Html::tag('span', '+ ' . $new_orders_count, $label_options) : '';

$new_travel_count = \app\models\FreeTravel::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_travel_label = $new_travel_count ? Html::tag('span', '+ ' . $new_travel_count, $label_options) : '';

$new_calculate_count = \app\models\Calculate::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_calculate_label = $new_calculate_count ? Html::tag('span', '+ ' . $new_calculate_count, $label_options) : '';

$new_callback_count = \app\models\Callback::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_callback_label = $new_callback_count ? Html::tag('span', '+ ' . $new_callback_count, $label_options) : '';

$new_question_count = \app\models\Faq::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_question_label = $new_question_count ? Html::tag('span', '+ ' . $new_question_count, $label_options) : '';

$new_reviews_count = \app\models\Reviews::find()->where(['status' => Statuses::STATUS_DISABLED])->count();
$new_reviews_label = $new_reviews_count ? Html::tag('span', '+ ' . $new_reviews_count, $label_options) : '';

echo Nav::widget([
    'items' => [
        ['label' => 'Главная','url' => ['default/index']],
    ],
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

echo Nav::widget([
    'items' => [
        ['label' => $new_orders_label . OrdersController::LIST_NAME, 'url' => ['orders/list']],
        ['label' => $new_travel_label . FreeTravelController::LIST_NAME, 'url' => ['free-travel/list']],
        ['label' => $new_calculate_label . CalculateController::LIST_NAME, 'url' => ['calculate/list']],
        ['label' => $new_callback_label . CallbackController::LIST_NAME, 'url' => ['callback/list']],
        ['label' => $new_reviews_label . ReviewsController::LIST_NAME , 'url' => ['reviews/list']],
        ['label' => $new_question_label . 'Вопросы и ответы', 'url' => ['faq/list']],
        ['label' => 'Разделы вопросов', 'url' => ['faq/sections']],

    ],
    'encodeLabels' => false,
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

echo Nav::widget([
    'items' => [
        ['label' => 'Меню','url' => ['menu/list']],
        ['label' => 'Страницы', 'url' => ['pages/list']],
        ['label' => PhotosController::LIST_NAME,'url' => ['photos/sections']],
        /*['label' => 'Новости','url' => '#','linkOptions' => ['class' => 'text-muted']],*/
    ],
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

if (Yii::$app->user->identity->role == \app\models\Users::ROLE_ADMIN):

echo Nav::widget([
    'items' => [
        ['label' => 'Пользователи','url' => ['users/list']],
        ['label' => 'Шаблоны писем','url' => ['mail/templates']],
        ['label' => 'Тексты сайта','url' => ['vars/list']],
        ['label' => 'Карта сайта','url' => ['/site/sitemap'], 'linkOptions' => ['target' => '_blank']],
        ['label' => 'Настройки','url' => ['settings/index']],
    ],
    'options' => ['class' =>'nav nav-sidebar'], // set this to nav-tab to get tab-styled navigation
]);

endif;