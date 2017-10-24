<?php
namespace app\modules\admin\controllers;

use app\helpers\Statuses;
use app\models\Videos;
use Yii;
use yii\data\Pagination;
use yii\web\Controller;

class VideosController extends Controller
{
    const LIST_NAME = 'Видеослайдер';

    protected function notFound($message = 'Видеозапись не найдена') {
        Yii::$app->session->setFlash('error', $message);
        return $this->redirect(['sections']);
    }

    public function actionList() {
        $query = Videos::find()->manage()->ordering();

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);
    
        $videos = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render('list', [
            'pages' => $pages,
            'videos' => $videos,
        ]);
    }
    
    public function actionAdd() {
        
        $model = new Videos();
        
        if (Yii::$app->request->post('Videos')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                return $this->redirect(['list']);
            }
        }
        
        return $this->render('add', [
            'model' => $model
        ]);
    }
    
    public function actionEdit($id) {
        
        $model = Videos::findOne($id);
        if (!$model) return $this->notFound();
        
        if (Yii::$app->request->post('Videos')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                return $this->redirect(['list']);
            }
        }
        
        return $this->render('add', [
            'model' => $model
        ]);
    }
    
    public function actionDelete($id, $confirmed = false) {
        
        $model = Videos::findOne($id);
        if (!$model) $this->notFound();
        
        if ($confirmed) {
            $model->updateAttributes(['status' => Statuses::STATUS_REMOVED]);
            Yii::$app->session->setFlash('success', 'Новость успешно удалена');
            return $this->redirect(['list']);
        }
        
        return $this->render('delete', [
            'model' => $model
        ]);
    }
    
    public function actionTrash($id) {
        $this->actionDelete($id, true);
    }
}