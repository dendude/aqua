<?php

namespace app\widgets;

use yii\base\Widget;

class SidebarAdmin extends Widget {

	public function init() {

		echo $this->render('SidebarAdmin');
	}
}