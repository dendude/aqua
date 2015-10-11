<?php

namespace app\modules\admin\controllers;

use app\models\Vars;
use app\models\search\VarsSearch;
use Yii;
use yii\web\Controller;
use yii\web\Session;

class VarsController extends Controller
{
    const LIST_NAME = 'Текстовые переменные сайта';

    protected function notFound() {
        Yii::$app->session->setFlash('error', 'Тестовая переменная не найдена');
        $this->redirect(['list'])->send();
    }

    public function actionSwitch() {
        Yii::$app->session->set(Vars::SESSION_NAME, Yii::$app->request->get('vars'));
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new VarsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd()
    {
        $model = new Vars();

        if (Yii::$app->request->post('Vars')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Переменная успешно добавлена');
                $this->redirect(['list'])->send();
            }
        }

        return $this->render(
            'add', [
                'model' => $model
            ]
        );
    }

    public function actionEdit($id)
    {
        $model = Vars::findOne($id);

        if (!$model) $this->notFound();

        if (Yii::$app->request->post('Vars')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Переменная успешно изменена');
                $this->redirect(['list'])->send();
            }
        }

        return $this->render(
            'add', [
                'model' => $model
            ]
        );
    }
}