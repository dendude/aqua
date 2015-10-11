<?php

namespace app\modules\admin\controllers;

use app\models\forms\UploadForm;
use app\models\Actions;
use app\models\ActionsSections;
use app\models\search\ActionsSectionsSearch;
use app\models\search\ActionsSearch;
use Yii;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class ActionsController extends Controller
{
    const LIST_NAME = 'Акции';
    const LIST_SECTIONS = 'Разделы акций';

    public function beforeAction($action)
    {
        if ($action->id == 'upload') {
            Yii::$app->request->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

    protected function notFound($message = 'Акция не найдена') {
        Yii::$app->session->setFlash('error', $message);
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new ActionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Actions();

        if (Yii::$app->request->post('Actions')) {

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

        $model = Actions::findOne($id);
        if ($model) {

            if (Yii::$app->request->post('Actions')) {

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
        $model = Actions::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Actions::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Акция успешно удалена');

        $model->delete();
        $this->redirect(['list'])->send();
    }

    public function actionShow($id)
    {
        $model = Actions::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->response->redirect([Actions::ALIAS_PREFIX . $model->alias])->send();
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
        $searchModel = new ActionsSectionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'sections', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionSectionAdd() {
        $model = new ActionsSections();

        if (Yii::$app->request->post('ActionsSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел акций успешно сохранен');
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
        $model = ActionsSections::findOne($id);

        if (!$model) $this->notFound('Раздел акций не найден');

        if (Yii::$app->request->post('ActionsSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел акций успешно изменен');
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
        $model = ActionsSections::findOne($id);

        if (!$model) $this->notFound('Раздел акций не найден');

        return $this->render(
            'section-delete', [
                'model' => $model
            ]
        );
    }

    public function actionSectionTrash($id)
    {
        $model = ActionsSections::findOne($id);

        if (!$model) $this->notFound('Раздел акций не найден');

        Yii::$app->session->setFlash('success', 'Раздел акций успешно удален');

        $model->delete();
        $this->redirect(['sections'])->send();
    }
}