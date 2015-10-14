<?php

namespace app\widgets;

use \Yii;
use app\models\forms\LoginForm;
use yii\base\Widget;
use yii\bootstrap\Modal;
use yii\helpers\Html;

class ModalLogin extends Widget {

    public $model;

	public function init() {

        if (!$this->model) {
            Modal::begin(['id' => 'modal_login',
                'header' => Html::tag('h3', Yii::$app->vars->val(34), ['class' => 'modal-title']),
                'footer' => Html::tag('button', Yii::$app->vars->val(35), ['class' => 'btn btn-default', 'data-dismiss' => 'modal'])]);
        }

        $model = $this->model;
        if (!$model) $model = new LoginForm();

		echo $this->render(
            'ModalLogin', [
                'model' => $model
            ]
        );

        if (!$this->model) {
            Modal::end();
        }
	}
}