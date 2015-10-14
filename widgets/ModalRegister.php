<?php

namespace app\widgets;
use Yii;
use app\models\forms\RegisterForm;
use yii\base\Widget;
use yii\bootstrap\Modal;
use yii\helpers\Html;

class ModalRegister extends Widget {

    public $model;

	public function init() {

        if (!$this->model) {
            Modal::begin(['id' => 'modal_register',
                'header' => Html::tag('h3', Yii::$app->vars->val(32), ['class' => 'modal-title']),
                'footer' => Html::tag('button', Yii::$app->vars->val(33), ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])]);
        }

        $model = $this->model;
        if (!$model) $model = new RegisterForm();

		echo $this->render(
            'ModalRegister', [
                'model' => $model
            ]
        );

        if (!$this->model) {
            Modal::end();
        }
	}
}