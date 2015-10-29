<?php

namespace app\controllers;

use app\components\DSitemap;
use app\helpers\Normalize;
use app\helpers\Statuses;
use app\models\Actions;
use app\models\Calculate;
use app\models\Callback;
use app\models\Faq;
use app\models\forms\QuestionForm;
use app\models\forms\ReviewForm;
use app\models\FreeTravel;
use app\models\News;
use app\models\Pages;
use app\models\PhotoAlbums;
use app\models\Photos;
use app\models\Results;
use app\models\Reviews;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\forms\LoginForm;
use yii\web\NotFoundHttpException;

class SiteController extends Controller
{
    public $breadcrumbs = [];

    public $meta_t;
    public $meta_d;
    public $meta_k;

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionNew($alias) {

        $model = News::find()->where(['alias' => $alias])->one();

        if ($model) {
            $model->updateCounters(['views' => 1]);

            return $this->render('new', [
                'model' => $model
            ]);
        }

        throw new NotFoundHttpException('Страница не найдена', 404);
    }

    public function actionResult($alias) {

        $model = Results::find()->where(['alias' => $alias])->one();

        if ($model) {
            $model->updateCounters(['views' => 1]);

            return $this->render('result', [
                'model' => $model
            ]);
        }

        throw new NotFoundHttpException('Страница не найдена', 404);
    }

    public function actionAnswer($id) {

        $model = Faq::findOne($id);

        if ($model) {
            $model->updateCounters(['views' => 1]);

            return $this->render('answer', [
                'model' => $model
            ]);
        }

        throw new NotFoundHttpException('Страница не найдена', 404);
    }

    public function actionAction($alias) {

        $model = Actions::find()->where(['alias' => $alias])->one();

        if ($model) {
            $model->updateCounters(['views' => 1]);

            return $this->render('action', [
                'model' => $model
            ]);
        }

        throw new NotFoundHttpException('Страница не найдена', 404);
    }

    public function actionCalculator() {
        $page = Pages::findOne(176);
        return $this->render('calculator', [
            'model' => $page
        ]);
    }

    public function actionNews($section = 0) {
        $page = Pages::findOne(News::PAGE_ID);
        return $this->render('news', [
            'model' => $page,
            'section_id' => $section
        ]);
    }

    public function actionResults($section = 0) {
        $page = Pages::findOne(Results::PAGE_ID);
        return $this->render('results', [
            'model' => $page,
            'section_id' => $section
        ]);
    }

    public function actionFaq($section = 0) {
        $page = Pages::findOne(Faq::PAGE_ID);
        return $this->render('questions', [
            'model' => $page,
            'section_id' => $section
        ]);
    }

    public function actionActions($section = 0) {
        $page = Pages::findOne(Actions::PAGE_ID);
        return $this->render('actions', [
            'model' => $page,
            'section_id' => $section
        ]);
    }

    public function actionQuestionAdd() {

        $page = Pages::findOne(Faq::PAGE_ADD_ID);
        $model = new QuestionForm();
        $result = null;

        if (Yii::$app->request->post('QuestionForm')) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->send()) {
                $result = Yii::$app->vars->val(52);
            }
        }

        return $this->render('question-add',[
            'page' => $page,
            'model' => $model,
            'result' => $result
        ]);
    }

    public function actionReviews() {
        $page = Pages::findOne(Reviews::PAGE_ID);
        return $this->render('reviews', [
            'model' => $page
        ]);
    }

    public function actionGallery() {
        $page = Pages::findOne(PhotoAlbums::PAGE_ID);
        return $this->render('gallery', [
            'model' => $page
        ]);
    }

    public function actionAlbum($id = 0) {

        if ($id) {
            $album = PhotoAlbums::findOne($id);
            if ($album) {
                $page = Pages::findOne(PhotoAlbums::PAGE_ID);
                return $this->render('gallery-album', [
                    'page' => $page,
                    'album' => $album
                ]);
            }
        }

        throw new NotFoundHttpException('Страница не найдена', 404);
    }

    public function actionReviewAdd() {

        $page = Pages::findOne(Reviews::PAGE_ADD_ID);
        $model = new ReviewForm();
        $result = null;

        if (Yii::$app->request->post('ReviewForm')) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->send()) {
                $result = Yii::$app->vars->val(53);
            }
        }

        return $this->render('review-add',[
            'page' => $page,
            'model' => $model,
            'result' => $result
        ]);
    }

    public function actionPage($alias, $id = 0) {

        $page = Pages::find()->where(['alias' => $alias])->one();

        if ($page) {
            $page->updateCounters(['views' => 1]);

            $render_page = null;

            if ($page->is_auto) {
                // автоматическая страница
                switch ($page->id) {

                    case 17:
                        $render_page = 'contact';
                        break;
                    case 31:
                        $render_page = 'program';
                        break;
                    case 33:
                        $render_page = 'products';
                        break;
                    case 34:
                        $render_page = 'catalog';
                        break;
                    case 35:
                        $render_page = 'price';
                        break;
                    case 36:
                        $render_page = 'partners';
                        break;
                    case 56:
                        $render_page = 'articles';
                        break;
                    case 141:
                        $render_page = 'cosmetics';
                        break;
                    case 176:
                        return $this->actionCalculator($id);
                        break;
                    case 212:
                        $render_page = 'order';
                        break;

                    case Pages::SEARCH_ID :
                        $render_page = 'search';
                        break;

                    case PhotoAlbums::PAGE_ID :
                        return $this->actionGallery();
                        break;

                    case Actions::PAGE_ID :
                        return $this->actionActions($id);
                        break;

                    case News::PAGE_ID :
                        return $this->actionNews($id);
                        break;

                    case Results::PAGE_ID:
                        return $this->actionResults($id);
                        break;

                    case Faq::PAGE_ADD_ID:
                        return $this->actionQuestionAdd();
                        break;
                    case Faq::PAGE_ID:
                        return $this->actionFaq($id);
                        break;

                    case FreeTravel::PAGE_ID:
                    case Callback::PAGE_ID:
                    case Calculate::PAGE_ID:
                        $render_page = 'reviews';
                        break;
                }

                if ($render_page) {
                    return $this->render('auto', [
                        'content' => $this->renderPartial($render_page, ['model' => $page]),
                        'model' => $page
                    ]);
                }

            } else {
                $render_page = 'page';
            }

            if ($render_page) {
                return $this->render($render_page, [
                    'model' => $page
                ]);
            }
        }

        throw new NotFoundHttpException('Страница не найдена', 404);
    }

    public function actionIndex() {
        $model = Pages::find()->where(['alias' => 'index'])->one();
        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    public function actionSitemap() {

        $sitemap = new DSitemap();

        $pages = Pages::find()->where(['is_sitemap' => 1])->all();

        if ($pages) {
            foreach($pages AS $pageInfo) {

                $pageUrl = Url::to([Normalize::fixAlias($pageInfo->alias)], true);

                if ($pageUrl !== null) {
                    $pageMod = $pageInfo->modified ? $pageInfo->modified : $pageInfo->created;
                    $sitemap->addUrl($pageUrl, DSitemap::WEEKLY, 0.5, $pageMod);
                }
            }
        }

        header("Content-type: text/xml");
        echo $sitemap->render();
        Yii::$app->end();
    }
}
