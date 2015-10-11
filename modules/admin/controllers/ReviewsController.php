<?php

namespace app\modules\admin\controllers;

use app\models\Reviews;
use app\models\search\ReviewsSearch;
use Yii;
use yii\web\Controller;

class ReviewsController extends Controller
{
    const LIST_NAME = 'Отзывы';

    protected function notFound() {
        Yii::$app->session->setFlash('error', 'Отзыв не найден');
        $this->redirect(['list'])->send();
    }

    public function actionList() {

        $searchModel = new ReviewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Reviews();

        if (Yii::$app->request->post('Reviews')) {
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

        $model = Reviews::findOne($id);

        if (!$model) $this->notFound();

        if (Yii::$app->request->post('Reviews')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Запись успешно изменена');
                $this->redirect(['list'])->send();
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
        $model = Reviews::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Reviews::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Отзыв успешно удален');

        $model->delete();
        $this->redirect(['list'])->send();
    }
}