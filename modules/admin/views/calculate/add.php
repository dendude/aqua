<?php
use yii\helpers\Html;
use yii\widgets\ActiveForm;
use app\modules\admin\controllers\CalculateController;
use app\helpers\Statuses;

$this->title = $model->id ? 'Редактирование заявки на расчет аквариума' : 'Добавление заявки на расчет аквариума';
$this->params['breadcrumbs'] = [
    ['label' => CalculateController::LIST_NAME, 'url' => ['list']],
    ['label' => $this->title]
];

$form = ActiveForm::begin([
    'enableClientScript' => false,
    'enableClientValidation' => false,
    'fieldConfig' => [
        'template' => '<div class="col-xs-3 text-right">{label}</div><div class="col-xs-8">{input}{error}</div>'
    ],
]);

$inputSmall = ['inputOptions' => ['class' => 'form-control input-small']];
$inputMiddle = ['inputOptions' => ['class' => 'form-control input-middle']];
?>
<div class="clearfix"></div>
<div class="row">
    <div class="col-xs-12 col-lg-9">
        <?/*= $form->errorSummary($model, ['class' => 'alert alert-danger']); */?>
        <? \app\helpers\MHtml::alertMsg(); ?>
        <div class="well">
            <?
            echo '<div class="form-group">';
            echo Html::tag('div', '<label></label> - поля, обязательные для заполнения', ['class' => 'required col-xs-offset-3 col-xs-8']);
            echo '</div>';
            echo $form->field($model, 'name')->label(Yii::$app->vars->val(129));
            echo $form->field($model, 'email')->textInput(['placeholder' => Yii::$app->vars->val(143)])->label(Yii::$app->vars->val(130));
            echo $form->field($model, 'phone')->label(Yii::$app->vars->val(131));
            ?>
            <div class="form-group required">
                <label class="control-label col-xs-3" for=""><?= Yii::$app->vars->val(128) ?></label>
                <div class="col-xs-8">
                    <div class="row">
                        <div class="col-xs-4 field-<?= Html::getInputId($model, 'param_length') ?>">
                            <div class="input-group">
                                <?= Html::activeTextInput($model, 'param_length', ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('param_length')]) ?>
                                <span class="input-group-addon"><?= Yii::$app->vars->val(127) ?></span>
                            </div>
                            <?= $form->field($model, 'param_length', ['options' => ['class' => ''], 'template' => '{error}']) ?>
                        </div>
                        <div class="col-xs-4 field-<?= Html::getInputId($model, 'param_width') ?>">
                            <div class="input-group">
                                <?= Html::activeTextInput($model, 'param_width', ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('param_width')]) ?>
                                <span class="input-group-addon"><?= Yii::$app->vars->val(127) ?></span>
                            </div>
                            <?= $form->field($model, 'param_width', ['options' => ['class' => ''], 'template' => '{error}']) ?>
                        </div>
                        <div class="col-xs-4 field-<?= Html::getInputId($model, 'param_height') ?>">
                            <div class="input-group">
                                <?= Html::activeTextInput($model, 'param_height', ['class' => 'form-control', 'placeholder' => $model->getAttributeLabel('param_height')]) ?>
                                <span class="input-group-addon"><?= Yii::$app->vars->val(127) ?></span>
                            </div>
                            <?= $form->field($model, 'param_height', ['options' => ['class' => ''], 'template' => '{error}']) ?>
                        </div>
                    </div>
                </div>
            </div>
            <?= $form->field($model, 'param_oform_type')->dropDownList(\app\models\Calculate::getOformTypes(), ['prompt' => ''])->label(Yii::$app->vars->val(133)); ?>
            <div class="form-group">
                <label class="col-xs-3 text-right" for=""><?= Yii::$app->vars->val(126) ?></label>
                <div class="col-xs-8">
                    <table>
                        <tr>
                            <td>
                                <label class="cur-p" for="<?= Html::getInputId($model, 'param_has_krishka') ?>">
                                    <?= Html::activeCheckbox($model, 'param_has_krishka', ['label' => Yii::$app->vars->val(134)]) ?>
                                </label>
                            </td>
                            <td width="50">&nbsp;</td>
                            <td>
                                <label class="cur-p" for="<?= Html::getInputId($model, 'param_has_tumba') ?>">
                                    <?= Html::activeCheckbox($model, 'param_has_tumba', ['label' => Yii::$app->vars->val(135)]) ?>
                                </label>
                            </td>
                            <td width="50">&nbsp;</td>
                            <td>
                                <label class="cur-p" for="<?= Html::getInputId($model, 'param_has_oborud') ?>">
                                    <?= Html::activeCheckbox($model, 'param_has_oborud', ['label' => Yii::$app->vars->val(136)]) ?>
                                </label>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <?= $form->field($model, 'message')->textarea(); ?>
            <div class="separator"></div>
            <?= $form->field($model, 'answer')->textarea(); ?>
            <div class="separator"></div>
            <?= $form->field($model, 'status')->checkbox(['label' => 'Отправить ответ на Email пользователю',
                                                          'value' => Statuses::STATUS_ACTIVE,
                                                        'uncheck' => Statuses::STATUS_USED]) ?>
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