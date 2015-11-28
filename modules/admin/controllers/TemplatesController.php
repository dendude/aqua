<?php

namespace app\modules\admin\controllers;

use yii\base\Controller;

class TemplatesController extends Controller
{
    public function actionTableCharacters() {
        return $this->renderPartial('table-characters');
    }

    public function actionTableAqua() {
        return $this->renderPartial('table-aqua');
    }

    public function actionTableFill() {
        return $this->renderPartial('table-fill');
    }

    public function actionBlueBlockLeft() {
        return $this->renderPartial('blue-block-left');
    }

    public function actionBlueBlockRight() {
        return $this->renderPartial('blue-block-right');
    }
}