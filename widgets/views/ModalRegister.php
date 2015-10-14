<?
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'register_form',
    'action' => ['auth/register'],
    'enableClientScript' => true,
    'enableClientValidation' => true,
    'options' => [
        'class' => 'form-horizontal',
        'onsubmit' => 'user_register(this,event)',
    ],
    'fieldConfig' => [
        'template' => '<div class="col-xs-5 text-right">{label}</div><div class="col-xs-7">{input}{error}</div>'
    ],
]);

$inputOptions = ['inputOptions' => ['class' => 'form-control']];
?>
<div id="status_result" class="alert alert-info">
    <?= Yii::$app->vars->val(30) ?>
</div>
<div class="row">
    <div class="col-xs-offset-1 col-xs-10">
        <?= $form->field($model, 'name', $inputOptions)->textInput() ?>
        <?= $form->field($model, 'email', $inputOptions)->textInput() ?>
        <?= $form->field($model, 'password', $inputOptions)->passwordInput() ?>
        <?= $form->field($model, 'password2', $inputOptions)->passwordInput() ?>
        <div class="form-group break-btn">
            <div class="col-xs-offset-5 col-xs-7">
                <button class="btn btn-primary"><?= Yii::$app->vars->val(31) ?></button>
            </div>
        </div>
    </div>
</div>
<?
ActiveForm::end();
$this->registerJsFile('/js/auth.js');