<?php

namespace app\modules\admin\controllers;

use app\models\forms\UploadForm;
use app\models\PhotoAlbums;
use app\models\Photos;
use Yii;
use yii\data\Pagination;
use yii\helpers\Json;
use yii\web\Controller;
use yii\web\UploadedFile;

class PhotosController extends Controller
{
    const LIST_NAME = 'Баннеры';
    const LIST_SECTIONS = 'Фотоальбомы';

    public function beforeAction($action)
    {
        if ($action->id == 'upload') {
            Yii::$app->request->enableCsrfValidation = false;
        }

        return parent::beforeAction($action);
    }

    protected function notFound($message = 'Фотография не найдена') {
        Yii::$app->session->setFlash('error', $message);
        $this->redirect(['sections'])->send();
    }

    public function actionList($id)
    {
        if ($id) {

            $album = PhotoAlbums::findOne($id);
            if ($album) {

                // выбран альбом
                $query = Photos::find()->where(['section_id' => $id])->orderBy(['ordering' => SORT_ASC, 'id' => SORT_ASC]);

                $countQuery = clone $query;
                $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 10]);

                $photos = $query->offset($pages->offset)->limit($pages->limit)->all();

                return $this->render(
                    'list', [
                        'album' => $album,
                        'pages' => $pages,
                        'photos' => $photos
                    ]
                );
            }
        }

        Yii::$app->session->setFlash('error', 'Фотоальбом не найден');
        $this->redirect(['list'])->send();
    }

    public function actionAdd() {

        $model = new Photos();
        $model->section_id = Yii::$app->request->get('section',0);

        if (Yii::$app->request->post('Photos')) {
            $model->load(Yii::$app->request->post());

            if (is_array($model->img_small_arr) && count($model->img_small_arr)) {

                foreach ($model->img_small_arr AS $mk => $mv) {

                    $photo = new Photos();
                    $photo->section_id = $model->section_id;
                    $photo->img_small = basename($model->img_small_arr[$mk]);
                    $photo->img_big = basename($model->img_big_arr[$mk]);
                    $photo->title = $model->title_arr[$mk];
                    $photo->about = $model->about_arr[$mk];
                    $photo->ordering = $model->ordering_arr[$mk];
                    if ($photo->save()) {
                        $this->redirect(['list', 'id' => $model->section_id])->send();
                    } else {
                        Yii::$app->session->setFlash('error', print_r($photo->getErrors(),1));
                    }
                }


            }
        }

        return $this->render(
            'add', [
                'model' => $model
            ]
        );
    }

    public function actionEdit($id) {

        $model = Photos::findOne($id);
        if ($model) {

            if (Yii::$app->request->post('Photos')) {
                $model->load(Yii::$app->request->post());
                if ($model->save()) {
                    $this->redirect(['list', 'id' => $model->section_id])->send();
                }
            }

            return $this->render(
                'edit', [
                    'model' => $model
                ]
            );

        } else {
            $this->notFound();
        }
    }

    public function actionDelete($id)
    {
        $model = Photos::findOne($id);

        if (!$model) $this->notFound();

        return $this->render(
            'delete', [
                'model' => $model
            ]
        );
    }

    public function actionTrash($id)
    {
        $model = Photos::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->session->setFlash('success', 'Фотография успешно удалена');

        $model->delete();
        $this->redirect(['list', 'id' => $model->section_id])->send();
    }

    public function actionShow($id)
    {
        $model = Photos::findOne($id);

        if (!$model) $this->notFound();

        Yii::$app->response->redirect([Photos::ALIAS_PREFIX . $model->alias])->send();
    }

    public function actionUpload() {

        $upload_form = new UploadForm();
        $upload_form->imageFile = UploadedFile::getInstance($upload_form, 'imageFile');
        if ($upload_form->upload(UploadForm::TYPE_GALLERY)) {
            echo Json::encode(['img_small' => $upload_form->getImagePath(false, true),
                                 'img_big' => $upload_form->getImagePath()]);
        } else {
            echo Json::encode($upload_form->getErrors());
        }
    }

    public function actionSections()
    {
        $query = PhotoAlbums::find()->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC]);

        $countQuery = clone $query;
        $pages = new Pagination(['totalCount' => $countQuery->count(), 'pageSize' => 5]);

        $albums = $query->offset($pages->offset)->limit($pages->limit)->all();

        return $this->render(
            'sections', [
                'pages' => $pages,
                'albums' => $albums
            ]
        );
    }

    public function actionSectionAdd() {
        $model = new PhotoAlbums();

        if (Yii::$app->request->post('PhotoAlbums')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Фотоальбом успешно сохранен');
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
        $model = PhotoAlbums::findOne($id);

        if (!$model) $this->notFound('Раздел не найден');

        if (Yii::$app->request->post('PhotoAlbums')) {
            $model->load(Yii::$app->request->post());
            if ($model->save()) {
                Yii::$app->session->setFlash('success', 'Фотоальбом успешно изменен');
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
        $model = PhotoAlbums::findOne($id);

        if (!$model) $this->notFound('Раздел не найден');

        return $this->render(
            'section-delete', [
                'model' => $model
            ]
        );
    }

    public function actionSectionTrash($id)
    {
        $model = PhotoAlbums::findOne($id);

        if (!$model) $this->notFound('Раздел не найден');

        Yii::$app->session->setFlash('success', 'Фотоальбом успешно удален');

        $model->delete();
        $this->redirect(['sections'])->send();
    }
}