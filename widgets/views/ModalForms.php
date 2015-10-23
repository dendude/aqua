<?
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;

use app\models\FreeTravel;
use app\models\Calculate;
use app\models\Callback;

/** бесплатный выезд специалиста */
$model = new FreeTravel();
Modal::begin([
    'id' => 'modal_form_98',
    'header' => Html::tag('div', Yii::$app->vars->val(104), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);
echo Html::tag('div', '', ['class' => 'hidden']);
$form = ActiveForm::begin([
    'enableClientScript' => true,
    'enableClientValidation' => true,
]);
echo html::tag('div', Yii::$app->vars->val(113), ['class' => 'alert alert-info']);
echo '<div class="form-group">';
echo Html::tag('div', '<label></label> - поля, обязательные для заполнения', ['class' => 'required col-xs-offset-4 col-xs-8']);
echo '</div>';
echo $form->field($model, 'name')->label(Yii::$app->vars->val(109));
echo $form->field($model, 'phone')->label(Yii::$app->vars->val(110));
echo $form->field($model, 'email')->label(Yii::$app->vars->val(111));
echo $form->field($model, 'comment')->textarea()->label(Yii::$app->vars->val(112));
echo '<div class="form-group">';
echo Html::tag('div', Html::button(Yii::$app->vars->val(108), ['class' => 'btn btn-primary']), ['class' => 'col-xs-offset-4 col-xs-8']);
echo '</div>';
ActiveForm::end();
Modal::end();


/** расчитать аквариум */
$model = new Calculate();
Modal::begin([
    'id' => 'modal_form_99',
    //'size' => Modal::SIZE_LARGE,
    'header' => Html::tag('div', Yii::$app->vars->val(106), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);
echo 1;
Modal::end();


/** заказать звонок */
$model = new Callback();
Modal::begin([
    'id' => 'modal_form_100',
    'header' => Html::tag('div', Yii::$app->vars->val(107), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);

echo 1;

Modal::end();