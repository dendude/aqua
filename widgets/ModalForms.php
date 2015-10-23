<?php

namespace app\widgets;

use \Yii;
use yii\base\Widget;
use yii\bootstrap\Modal;

class ModalForms extends Widget {

	public function init() {
		echo $this->render('ModalForms');
	}
}