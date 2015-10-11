<?php

namespace app\modules\admin\controllers;

use app\models\forms\UploadForm;
use app\models\Results;
use app\models\ResultsSections;
use app\models\search\ResultsSectionsSearch;
use app\models\search\ResultsSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class ResultsController extends Controller
{
    const LIST_NAME = 'Результаты';
    const LIST_SECTIONS = 'Разделы результатов';

    public function beforeAction($action)
    {
        if ($action->id == 'upload') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    protected function notFound($message = 'Результат не найден') {
        Yii::$app->session->setFlash('error', $message);
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new ResultsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Results();

        if (Yii::$app->request->post('Results')) {

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

        $model = Results::findOne($id);
        if ($model) {

            if (Yii::$app->request->post('Results')) {

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
        $model = Results::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Results::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Результат успешно удален');

        $model->delete();
        $this->redirect(['list'])->send();
    }

    public function actionShow($id)
    {
        $model = Results::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->response->redirect([Results::ALIAS_PREFIX . $model->alias])->send();
    }

    public function actionUpload() {

        $upload_form = new UploadForm();
        $upload_form->imageFile = UploadedFile::getInstance($upload_form, 'imageFile');
        if ($upload_form->upload(UploadForm::TYPE_RESULTS)) {
            echo Json::encode(['filelink' => $upload_form->getImagePath()]);
        } else {
            echo Json::encode($upload_form->getErrors());
        }
    }

    public function actionSections()
    {
        $searchModel = new ResultsSectionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'sections', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionSectionAdd() {
        $model = new ResultsSections();

        if (Yii::$app->request->post('ResultsSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел результатов успешно сохранен');
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
        $model = ResultsSections::findOne($id);

        if (!$model) $this->notFound('Раздел результатов не найден');

        if (Yii::$app->request->post('ResultsSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел результатов успешно изменен');
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
        $model = ResultsSections::findOne($id);

        if (!$model) $this->notFound('Раздел результатов не найден');

        return $this->render(
            'section-delete', [
                'model' => $model
            ]
        );
    }

    public function actionSectionTrash($id)
    {
        $model = ResultsSections::findOne($id);

        if (!$model) $this->notFound('Раздел результатов не найден');

        Yii::$app->session->setFlash('success', 'Раздел результатов успешно удален');

        $model->delete();
        $this->redirect(['sections'])->send();
    }
}