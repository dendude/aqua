<?php

namespace app\modules\admin\controllers;

use yii\base\Controller;

class TemplatesController extends Controller
{
    public function actionTableCharacters() {
        return $this->renderPartial('table-characters');
    }
}