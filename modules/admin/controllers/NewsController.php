<?php

namespace app\modules\admin\controllers;

use app\models\forms\UploadForm;
use app\models\News;
use app\models\NewsSections;
use app\models\search\NewsSectionsSearch;
use app\models\search\NewsSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class NewsController extends Controller
{
    const LIST_NAME = 'Новости';
    const LIST_SECTIONS = 'Разделы новостей';

    public function beforeAction($action)
    {
        if ($action->id == 'upload') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    protected function notFound($message = 'Новость не найдена') {
        Yii::$app->session->setFlash('error', $message);
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new NewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new News();

        if (Yii::$app->request->post('News')) {

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

        $model = News::findOne($id);
        if ($model) {

            if (Yii::$app->request->post('News')) {

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
        $model = News::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = News::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Новость успешно удалена');

        $model->delete();
        $this->redirect(['list'])->send();
    }

    public function actionShow($id)
    {
        $model = News::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->response->redirect([News::ALIAS_PREFIX . $model->alias])->send();
    }

    public function actionUpload() {

        $upload_form = new UploadForm();
        $upload_form->imageFile = UploadedFile::getInstance($upload_form, 'imageFile');
        if ($upload_form->upload(UploadForm::TYPE_NEWS)) {
            echo Json::encode(['filelink' => $upload_form->getImagePath()]);
        } else {
            echo Json::encode($upload_form->getErrors());
        }
    }

    public function actionSections()
    {
        $searchModel = new NewsSectionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'sections', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionSectionAdd() {
        $model = new NewsSections();

        if (Yii::$app->request->post('NewsSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел новостей успешно сохранен');
                $this->redirect(['sections'])->send();
            }
        }

        return $this->render(
            'section-add', [
                'model' => $model
            ]
        );
    }

    public function actionSectionEdit($id)
    {
        $model = NewsSections::findOne($id);

        if (!$model) $this->notFound('Раздел не найден');

        if (Yii::$app->request->post('NewsSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел новостей успешно изменен');
                $this->redirect(['sections'])->send();
            }
        }

        return $this->render(
            'section-add', [
                'model' => $model
            ]
        );
    }

    public function actionSectionDelete($id)
    {
        $model = NewsSections::findOne($id);

        if (!$model) $this->notFound('Раздел не найден');

        return $this->render(
            'section-delete', [
                'model' => $model
            ]
        );
    }

    public function actionSectionTrash($id)
    {
        $model = NewsSections::findOne($id);

        if (!$model) $this->notFound('Раздел не найден');

        Yii::$app->session->setFlash('success', 'Раздел новостей успешно удален');

        $model->delete();
        $this->redirect(['sections'])->send();
    }
}