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
        'template' => '<div class="col-xs-12">{input}{error}</div>'
    ],
]);

$inputOptions = ['inputOptions' => ['class' => 'form-control']];
?>
    <div class="row">
        <div class="col-xs-offset-4 col-xs-4">
            <?= $form->field($model, 'email', $inputOptions)->textInput(['placeholder' => $model->getAttributeLabel('email')]) ?>
            <?= $form->field($model, 'password', $inputOptions)->textInput(['placeholder' => $model->getAttributeLabel('password')]) ?>
            <div class="form-group break-btn">
                <div class="col-xs-6">
                    <button class="btn btn-info btn-block" type="submit"><?= Yii::$app->vars->val(28) ?></button>
                </div>
                <div class="col-xs-6">
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