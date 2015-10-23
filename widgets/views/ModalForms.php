<?
use yii\bootstrap\Modal;
use yii\helpers\Html;
use yii\widgets\ActiveForm;


/** бесплатный выезд специалиста */

$model = new \app\models\FreeTravel();
Modal::begin([
    'id' => 'modal_form_98',
    'header' => Html::tag('div', Yii::$app->vars->val(104), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);
echo Html::tag('div', '', ['class' => 'alert hidden']);
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

$model = new \app\models\Calculate();
Modal::begin([
    'id' => 'modal_form_99',
    'size' => Modal::SIZE_LARGE,
    'header' => Html::tag('div', Yii::$app->vars->val(106), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);
echo Html::tag('div', '', ['class' => 'alert hidden']);
$form = ActiveForm::begin([
    'enableClientScript' => true,
    'enableClientValidation' => true,
    'fieldConfig' => [
        'template' => '<div class="col-xs-4 text-right">{label}</div><div class="col-xs-7">{input}{error}</div>'
    ],
]);
echo '<div class="form-group">';
echo Html::tag('div', '<label></label> - поля, обязательные для заполнения', ['class' => 'required col-xs-offset-4 col-xs-7']);
echo '</div>';
echo $form->field($model, 'name')->label(Yii::$app->vars->val(129));
echo $form->field($model, 'email')->textInput(['placeholder' => Yii::$app->vars->val(143)])->label(Yii::$app->vars->val(130));
echo $form->field($model, 'phone')->label(Yii::$app->vars->val(131));
?>
<div class="form-group required">
    <label class="control-label col-xs-4" for=""><?= Yii::$app->vars->val(128) ?></label>
    <div class="col-xs-7">
        <div class="row">
            <div class="col-xs-4">
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'param_length', ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('param_length')]) ?>
                    <span class="input-group-addon"><?= Yii::$app->vars->val(127) ?></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'param_width', ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('param_width')]) ?>
                    <span class="input-group-addon"><?= Yii::$app->vars->val(127) ?></span>
                </div>
            </div>
            <div class="col-xs-4">
                <div class="input-group">
                    <?= Html::activeTextInput($model, 'param_height', ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('param_height')]) ?>
                    <span class="input-group-addon"><?= Yii::$app->vars->val(127) ?></span>
                </div>
            </div>
        </div>
    </div>
</div>
<?= $form->field($model, 'param_oform_type')->dropDownList(\app\models\Calculate::getOformTypes(), ['prompt' => ''])->label(Yii::$app->vars->val(133)); ?>
<div class="form-group">
    <label class="col-xs-4 text-right" for=""><?= Yii::$app->vars->val(126) ?></label>
    <div class="col-xs-7">
        <div class="row">
            <div class="col-xs-4">
                <label for="<?= Html::getInputId($model, 'param_has_krishka') ?>">
                    <?= Html::activeCheckbox($model, 'param_has_krishka', ['label' => Yii::$app->vars->val(134)]) ?>
                </label>
            </div>
            <div class="col-xs-4">
                <label for="<?= Html::getInputId($model, 'param_has_tumba') ?>">
                    <?= Html::activeCheckbox($model, 'param_has_tumba', ['label' => Yii::$app->vars->val(135)]) ?>
                </label>
            </div>
            <div class="col-xs-4">
                <label for="<?= Html::getInputId($model, 'param_has_oborud') ?>">
                    <?= Html::activeCheckbox($model, 'param_has_oborud', ['label' => Yii::$app->vars->val(136)]) ?>
                </label>
            </div>
        </div>
    </div>
</div>
<?
echo $form->field($model, 'message')->textarea(['placeholder' => Yii::$app->vars->val(144)])->label(Yii::$app->vars->val(132));
echo '<div class="form-group">';
echo Html::tag('div', Html::button(Yii::$app->vars->val(108), ['class' => 'btn btn-primary']), ['class' => 'col-xs-offset-4 col-xs-7']);
echo '</div>';
ActiveForm::end();
Modal::end();


/** заказать звонок */

$model = new \app\models\Callback();
Modal::begin([
    'id' => 'modal_form_100',
    'header' => Html::tag('div', Yii::$app->vars->val(107), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);
echo Html::tag('div', '', ['class' => 'alert hidden']);
$form = ActiveForm::begin([
    'enableClientScript' => true,
    'enableClientValidation' => true,
]);
echo html::tag('div', Yii::$app->vars->val(142), ['class' => 'alert alert-info']);
echo '<div class="form-group">';
echo Html::tag('div', '<label></label> - поля, обязательные для заполнения', ['class' => 'required col-xs-offset-4 col-xs-8']);
echo '</div>';
echo $form->field($model, 'name')->label(Yii::$app->vars->val(137));
echo $form->field($model, 'phone')->label(Yii::$app->vars->val(139));
echo $form->field($model, 'comment')->textarea(['placeholder' => Yii::$app->vars->val(141)])->label(Yii::$app->vars->val(140));
echo '<div class="form-group">';
echo Html::tag('div', Html::button(Yii::$app->vars->val(108), ['class' => 'btn btn-primary']), ['class' => 'col-xs-offset-4 col-xs-8']);
echo '</div>';
ActiveForm::end();
Modal::end();


/** задать вопрос */

$model = new \app\models\forms\QuestionForm();
Modal::begin([
    'id' => 'modal_form_' . \app\models\Faq::PAGE_ADD_ID,
    'header' => Html::tag('div', Yii::$app->vars->val(121), ['class' => 'modal-title']),
    'footer' => Html::tag('button', Yii::$app->vars->val(105), ['class' => 'btn btn-default', 'data-dismiss' => 'modal']),
    'closeButton' => ['label' => '&times;'],
    'toggleButton' => false,
]);
echo Html::tag('div', '', ['class' => 'alert hidden']);
$form = ActiveForm::begin([
    'enableClientScript' => true,
    'enableClientValidation' => true,
]);
echo '<div class="form-group">';
echo Html::tag('div', '<label></label> - поля, обязательные для заполнения', ['class' => 'required col-xs-offset-4 col-xs-8']);
echo '</div>';
echo $form->field($model, 'name')->label(Yii::$app->vars->val(122));
echo $form->field($model, 'email')->label(Yii::$app->vars->val(123));
echo $form->field($model, 'section_id')->dropDownList(\app\models\FaqSections::getFilterList(true))->label(Yii::$app->vars->val(125));
echo $form->field($model, 'question_text')->textarea()->label(Yii::$app->vars->val(124));
echo '<div class="form-group">';
echo Html::tag('div', Html::button(Yii::$app->vars->val(108), ['class' => 'btn btn-primary']), ['class' => 'col-xs-offset-4 col-xs-8']);
echo '</div>';
ActiveForm::end();
Modal::end();