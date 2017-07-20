<?php

namespace app\modules\admin\controllers;

use app\helpers\Statuses;
use app\models\Calculate;
use app\models\search\CalculateSearch;
use Yii;
use yii\web\Controller;

class CalculateController extends Controller
{
    const LIST_NAME = 'Расчеты аквариумов';

    protected function notFound() {
        Yii::$app->session->setFlash('error', 'Заявка не найдена');
        $this->redirect(['list'])->send();
    }

    public function actionList() {

        $searchModel = new CalculateSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Calculate();

        if (Yii::$app->request->post('Calculate')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Запись успешно добавлена');
                $this->redirect(['list'])->send();
            }
        }

        return $this->render(
            'add', [
                'model' => $model
            ]
        );
    }

    public function actionEdit($id) {

        $model = Calculate::findOne($id);

        if (!$model) $this->notFound();

        if ($model->status == Statuses::STATUS_DISABLED) {
            $model->status = Statuses::STATUS_USED;
            $model->save();
        }

        if (Yii::$app->request->post('Calculate')) {
            $model->load(Yii::$app->request->post());

            if ($model->validate()) {
                if ($model->save()) {
                    Yii::$app->session->setFlash('success', 'Запись успешно изменена');
                    $this->redirect(['list'])->send();
                }
            }
        }

        return $this->render(
            'add', [
                'model' => $model
            ]
        );
    }

    public function actionDelete($id)
    {
        $model = Calculate::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Calculate::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Запись успешно удалена');

        $model->delete();
        $this->redirect(['list'])->send();
    }
}