<?
use yii\bootstrap\Modal;
use yii\helpers\Html;

// бесплатный выезд специалиста
Modal::begin([
    'id' => 'modal_form_98',
    'header' => Html::tag('div', Yii::$app->vars->val(104), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);

echo 1;

Modal::end();


// расчитать аквариум
Modal::begin([
    'id' => 'modal_form_99',
    'size' => Modal::SIZE_LARGE,
    'header' => Html::tag('div', Yii::$app->vars->val(106), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);

echo 1;

Modal::end();


// заказать звонок
Modal::begin([
    'id' => 'modal_form_100',
    'header' => Html::tag('div', Yii::$app->vars->val(107), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);

echo 1;

Modal::end();
?>