<?php

namespace app\widgets;

use app\models\Menu;
use yii\base\Widget;

class SidebarMenu extends Widget {

	public function init() {

		echo $this->render(
            'SidebarMenu', [
                'menu' => Menu::find()->sidebar()->active()->all()
            ]
        );
	}
}