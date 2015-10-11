<?php

namespace app\modules\admin\controllers;

use app\models\Settings;
use Yii;
use yii\web\Controller;

class SettingsController extends Controller
{
    public function actionIndex()
    {
        $model = Settings::lastSettings();

        if (Yii::$app->request->post('Settings')) {
            $model = new Settings();
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Настройки успешно сохранены');
                $this->redirect(['index'])->send();
            }
        }

        return $this->render(
            'index', [
                'model' => $model
            ]
        );
    }
}