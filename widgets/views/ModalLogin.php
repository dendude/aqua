<?
use yii\widgets\ActiveForm;

$form = ActiveForm::begin([
    'id' => 'login_form',
    'action' => ['auth/login'],
    'enableClientScript' => true,
    'enableClientValidation' => true,
    'options' => [
        'class' => 'form-horizontal',
        'onsubmit' => 'user_login(this,event)',
    ],
    'fieldConfig' => [
        'template' => '<div class="col-xs-4 text-right">{label}</div><div class="col-xs-8">{input}{error}</div>'
    ],
]);

$inputOptions = ['inputOptions' => ['class' => 'form-control']];
?>
<div class="row">
    <div class="col-xs-offset-1 col-xs-10">
        <?= $form->field($model, 'email', $inputOptions)->textInput() ?>
        <?= $form->field($model, 'password', $inputOptions)->passwordInput() ?>
        <div class="form-group break-btn">
            <div class="col-xs-offset-4 col-xs-4">
                <button class="btn btn-info btn-block" type="submit"><?= Yii::$app->vars->val(28) ?></button>
            </div>
            <div class="col-xs-4">
                <a href="<?= \yii\helpers\Url::to(['/auth/forgot']) ?>" class="btn btn-link btn-block">
                    <?= Yii::$app->vars->val(29) ?>
                </a>
            </div>
        </div>
    </div>
</div>
<?
ActiveForm::end();
$this->registerJsFile('/js/auth.js');