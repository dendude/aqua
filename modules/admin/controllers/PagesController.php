<?php

namespace app\modules\admin\controllers;

use app\models\forms\UploadForm;
use app\models\Pages;
use app\models\search\PagesSearch;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\UploadedFile;
use yii\widgets\Menu;

class PagesController extends Controller
{
    const LIST_NAME = 'Страницы сайта';

    public function beforeAction($action)
    {
        if ($action->id == 'upload') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }


    protected function notFound($message = 'Страница не найдена') {
        Yii::$app->session->setFlash('error', $message);
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new PagesSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Pages();

        if (Yii::$app->request->post('Pages')) {

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

        $model = Pages::findOne($id);
        if ($model) {

            if (Yii::$app->request->post('Pages')) {

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

        } else {
            $this->notFound();
        }
    }

    public function actionDelete($id)
    {
        $model = Pages::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Pages::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Страница успешно удалена');

        $model->delete();
        $this->redirect(['list'])->send();
    }

    public function actionShow($id)
    {
        $model = Pages::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->response->redirect([$model->alias])->send();
    }

    public function actionUpload() {

        $upload_form = new UploadForm();
        $upload_form->imageFile = UploadedFile::getInstance($upload_form, 'imageFile');
        if ($upload_form->upload()) {
            echo Json::encode(['filelink' => $upload_form->getImagePath()]);
        } else {
            echo Json::encode($upload_form->getErrors());
        }
    }
}