<?php

namespace app\modules\admin\controllers;

use app\helpers\Statuses;
use app\models\Feedback;
use app\models\search\FeedbackSearch;
use Yii;
use yii\web\Controller;

class FeedbackController extends Controller
{
    const LIST_NAME = 'Обратная связь';

    protected function notFound() {
        Yii::$app->session->setFlash('error', 'Сообщение не найдено');
        $this->redirect(['list'])->send();
    }

    public function actionList() {

        $searchModel = new FeedbackSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Feedback();

        if (Yii::$app->request->post('Feedback')) {
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

        $model = Feedback::findOne($id);

        if (!$model) $this->notFound();

        if ($model->status == Statuses::STATUS_DISABLED) {
            $model->status = Statuses::STATUS_USED;
            $model->save();
        }

        if (Yii::$app->request->post('Feedback')) {
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
        $model = Feedback::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Feedback::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Сообщение обратной связи успешно удалено');

        $model->delete();
        $this->redirect(['list'])->send();
    }
}