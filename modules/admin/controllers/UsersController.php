<?php

namespace app\modules\admin\controllers;

use app\helpers\Statuses;
use app\models\Users;
use Yii;
use yii\web\Controller;
use app\models\search\UsersSearch;

class UsersController extends Controller
{
    const LIST_NAME = 'Пользователи';

    protected function notFound() {
        Yii::$app->session->setFlash('error', 'Пользователь не найден');
        $this->redirect(['list'])->send();
    }

    public function actionList()
    {
        $searchModel = new UsersSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->get());

        return $this->render(
            'list', [
                'dataProvider' => $dataProvider,
                'searchModel' => $searchModel,
            ]
        );
    }

    public function actionAdd() {

        $model = new Users();

        if (Yii::$app->request->post('Users')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Пользователь успешно добавлен');
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

        $model = Users::findOne($id);

        if (!$model) $this->notFound();

        if (Yii::$app->request->post('Users')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Пользователь успешно изменен');
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
        $model = Users::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Users::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Пользователь успешно удален');

        $model->updateAttributes(['status' => Statuses::STATUS_REMOVED]);
        $this->redirect(['list'])->send();
    }
}