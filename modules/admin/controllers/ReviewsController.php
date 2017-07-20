<?php

namespace app\modules\admin\controllers;

use app\helpers\Statuses;
use app\models\forms\UploadFileForm;
use app\models\forms\UploadForm;
use app\models\Orders;
use app\models\Reviews;
use app\models\search\OrdersSearch;
use app\models\search\ReviewsSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class ReviewsController extends Controller
{
    const LIST_NAME = 'Отзывы';

    protected function notFound($message = 'Отзыв не найден') {
        Yii::$app->session->setFlash('error', $message);
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
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

        $model = Reviews::findOne($id);
        if ($model) {

            if ($model->status == Statuses::STATUS_DISABLED) {
                $model->updateAttributes(['status' => Statuses::STATUS_USED]);
            }

            if (Yii::$app->request->post('Reviews')) {

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

    public function actionShow($id)
    {
        $model = Reviews::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->response->redirect([$model->alias])->send();
    }

    public function actionUpload() {

        $upload_form = new UploadForm();
        $upload_form->imageFile = UploadedFile::getInstance($upload_form, 'imageFile');
        if ($upload_form->upload(UploadForm::TYPE_REVIEWS)) {

            echo Json::encode([
                'img_name' => basename($upload_form->getImagePath()),
                'img_small' => $upload_form->getImagePath()
            ]);
        } else {
            echo Json::encode($upload_form->getErrors());
        }
    }
}