<?php

namespace app\modules\admin\controllers;

use app\helpers\Statuses;
use app\models\Faq;
use app\models\FaqSections;
use app\models\search\FaqSearch;
use app\models\search\FaqSectionsSearch;
use Yii;
use yii\web\Controller;

class FaqController extends Controller
{
    const LIST_NAME = 'Список вопросов';
    const LIST_SECTIONS = 'Разделы вопросов';

    protected function notFound() {
        Yii::$app->session->setFlash('error', 'Раздел не найден');
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new FaqSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {
        $model = new Faq();

        if (Yii::$app->request->post('Faq')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Вопрос-ответ успешно сохранен');
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
        $model = Faq::findOne($id);

        if (!$model) $this->notFound();

        if ($model->status == Statuses::STATUS_DISABLED) {
            $model->status = Statuses::STATUS_USED;
            $model->save();
        }

        if (Yii::$app->request->post('Faq')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Вопрос-ответ успешно изменен');
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
        $model = Faq::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Faq::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Вопрос-ответ успешно удален');

        $model->delete();
        $this->redirect(['list'])->send();
    }



    public function actionSections()
    {
        $searchModel = new FaqSectionsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'sections', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionSectionAdd() {
        $model = new FaqSections();

        if (Yii::$app->request->post('FaqSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел успешно сохранен');
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
        $model = FaqSections::findOne($id);

        if (!$model) $this->notFound();

        if (Yii::$app->request->post('FaqSections')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Раздел успешно изменен');
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
        $model = FaqSections::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'section-delete', [
                'model' => $model
            ]
        );
    }

    public function actionSectionTrash($id)
    {
        $model = FaqSections::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Раздел успешно удален');

        $model->delete();
        $this->redirect(['sections'])->send();
    }
}