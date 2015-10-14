<?php

namespace app\widgets;

use app\models\Menu;
use yii\base\Widget;

class TopMenu extends Widget {

	public function init() {

		echo $this->render(
            'TopMenu', [
                'menu' => Menu::find()->top()->active()->all()
            ]
        );
	}
}