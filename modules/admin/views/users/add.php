<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\UsersController;
use app\models\Users;

$this->title = $model->id ? 'Редактирование пользователя' : 'Добавление пользователя';
$this->params['breadcrumbs'] = [
    ['label' => UsersController::LIST_NAME, 'url' => ['list']],
    ['label' => $this->title]
];

$form = ActiveForm::begin([
    'id' => 'add-form',
    // other options in config/web
]);

$inputSmall = ['inputOptions' => ['class' => 'form-control input-small']];
$inputMiddle = ['inputOptions' => ['class' => 'form-control input-middle']];
?>
    <div class="clearfix"></div>
    <div class="row">
        <div class="col-xs-12 col-md-9 col-lg-6">
            <?= $form->errorSummary($model, ['class' => 'alert alert-danger']); ?>
            <? \app\helpers\MHtml::alertMsg(); ?>
            <div class="well">
                <?= $form->field($model, 'role', $inputMiddle)->dropDownList(Users::getRolesNames()) ?>
                <div class="separator"></div>
                <?= $form->field($model, 'name', $inputMiddle) ?>
                <?= $form->field($model, 'phone', $inputMiddle) ?>
                <div class="separator"></div>
                <?= $form->field($model, 'email')->textInput(['placeholder' => 'Будет использоваться для входа']) ?>
                <? if ($model->isNewRecord): ?>
                    <?= $form->field($model, 'pass')->textInput(['placeholder' => 'Будет использоваться для входа']) ?>
                <? else: ?>
                    <?= $form->field($model, 'pass')->textInput(['value' => '', 'placeholder' => 'Оставить пустым для сохранения старого пароля']) ?>
                <? endif; ?>
                <div class="separator"></div>
                <?= $form->field($model, 'status')->checkbox(['label' => 'Активировать пользователя', 'value' => \app\helpers\Statuses::STATUS_ACTIVE]) ?>
                <div class="form-group">
                    <div class="col-xs-offset-4 col-xs-8">
                        <small class="text-muted">
                            Если не активировать пользователя, то он получит письмо на указанный Email со ссылкой для активации
                        </small>
                    </div>
                </div>
                <div class="separator"></div>
                <div class="form-group">
                    <div class="col-xs-offset-4 col-xs-2">
                        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-primary']) ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php ActiveForm::end() ?>