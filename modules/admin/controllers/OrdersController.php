<?php

namespace app\modules\admin\controllers;

use app\helpers\Statuses;
use app\models\forms\UploadFileForm;
use app\models\forms\UploadForm;
use app\models\Orders;
use app\models\search\OrdersSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class OrdersController extends Controller
{
    const LIST_NAME = 'Заказы аквариумов';

    protected function notFound($message = 'Заказ не найден') {
        Yii::$app->session->setFlash('error', $message);
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new OrdersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Orders();

        if (Yii::$app->request->post('Orders')) {

            $model->load(Yii::$app->request->post());
            if ($model->validate()) {

                $model->save();
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

        $model = Orders::findOne($id);
        if ($model) {

            if ($model->status == Statuses::STATUS_DISABLED) {
                $model->updateAttributes(['status' => Statuses::STATUS_USED]);
            }

            if (Yii::$app->request->post('Orders')) {

                $model->load(Yii::$app->request->post());
                if ($model->validate()) {
                    $model->save();
                    if (Yii::$app->request->post('refpage')) {
                        $this->redirect(Yii::$app->request->post('refpage'))->send();
                    } else {
                        $this->redirect(['list'])->send();
                    }
                }
            }

            return $this->render(
                'add', [
                    'model' => $model
                ]
            );

        } else {
            $this->notFound();
        }
    }

    public function actionDelete($id)
    {
        $model = Orders::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Orders::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Заказ успешно удален');

        $model->delete();
        $this->redirect(['list'])->send();
    }

    public function actionShow($id)
    {
        $model = Orders::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->response->redirect([$model->alias])->send();
    }
}