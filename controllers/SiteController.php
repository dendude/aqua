<?php

namespace app\controllers;

use app\components\DSitemap;
use app\components\ReCaptcha;
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
use app\models\Orders;
use app\models\Pages;
use app\models\PhotoAlbums;
use app\models\Photos;
use app\models\Results;
use app\models\Reviews;
use Yii;
use yii\data\Pagination;
use yii\filters\AccessControl;
use yii\helpers\Json;
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

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
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

    public function actionOrder() {

        if (Yii::$app->request->isAjax) {
            $model = new Orders();
            $_RESULT = ['status' => Statuses::STATUS_ERROR];

            if (Yii::$app->request->post('Orders')) {
                $model->load(Yii::$app->request->post());

                if ($model->validate()) {
                    if ($model->save()) {
                        $_RESULT['status'] = Statuses::STATUS_OK;
                        $_RESULT['message'] = Yii::$app->vars->val(160);
                    } else {
                        $_RESULT['error'] = 'Ошибка сохранения заказа. Пожалуйста, попробуйте позже.';
                    }
                } else {
                    $_RESULT['error'] = $model->getErrors();
                }
            }

            echo Json::encode($_RESULT);
        } else {
            $page = Pages::findOne(Pages::ORDER_ID_AQUA);
            return $this->render('order', [
                'model' => $page
            ]);
        }
    }

    /*public function actionOrderServices() {
        $page = Pages::findOne(Pages::ORDER_ID_SERVICES);
        return $this->render('order_services', [
            'model' => $page
        ]);
    }*/

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

    public function actionQuestionAdd()
    {
        $model = new QuestionForm();
        
        $_RESULT = ['status' => Statuses::STATUS_ERROR];

        if (Yii::$app->request->post('QuestionForm')) {
            
            $model->load(Yii::$app->request->post());
            $model->captcha = Yii::$app->request->post(ReCaptcha::FIELD_NAME);

            if ($model->validate()) {
                if ($model->send()) {
                    $_RESULT['status'] = Statuses::STATUS_OK;
                    $_RESULT['message'] = Yii::$app->vars->val(52);
                } else {
                    $_RESULT['error'] = 'Ошибка сохранения вопроса. Попробуйте позже.';
                }
            } else {
                $_RESULT['error'] = $model->getErrors();
            }
        }

        echo Json::encode($_RESULT);
    }

    public function actionWhyUs() {
        $page = Pages::findOne(Pages::WHY_US_ID);
        return $this->render('why-us', [
            'model' => $page
        ]);
    }

    public function actionReviews() {
        $page = Pages::findOne(Pages::REVIEWS_ID);
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

    public function actionSearch() {
        $page = Pages::findOne(Pages::SEARCH_ID);
        return $this->render('search', [
            'model' => $page
        ]);
    }

    public function actionOurMade() {
        $page = Pages::findOne(Pages::OUR_MADE_ID);
        return $this->render('our-made', [
            'model' => $page
        ]);
    }

    public function actionFreeTravel() {

        $model = new FreeTravel();
        $model->setScenario(FreeTravel::SCENARIO_SITE);
        
        $_RESULT = ['status' => Statuses::STATUS_ERROR];

        if (Yii::$app->request->post('FreeTravel')) {
            
            $model->load(Yii::$app->request->post());
            $model->captcha = Yii::$app->request->post(ReCaptcha::FIELD_NAME);

            if ($model->validate()) {
                $model->save(false);
                
                $_RESULT['status'] = Statuses::STATUS_OK;
                $_RESULT['message'] = Yii::$app->vars->val(161);
            } else {
                $_RESULT['error'] = $model->getErrors();
            }
        }

        echo Json::encode($_RESULT);
    }

    public function actionCalculate() {

        $model = new Calculate();
        $model->setScenario(Calculate::SCENARIO_SITE);
        
        $_RESULT = ['status' => Statuses::STATUS_ERROR];

        if (Yii::$app->request->post('Calculate')) {
            
            $model->load(Yii::$app->request->post());
            $model->captcha = Yii::$app->request->post(ReCaptcha::FIELD_NAME);

            if ($model->validate()) {
                $model->save(false);
                
                $_RESULT['status'] = Statuses::STATUS_OK;
                $_RESULT['message'] = Yii::$app->vars->val(162);
            } else {
                $_RESULT['error'] = $model->getErrors();
            }
        }

        echo Json::encode($_RESULT);
    }

    public function actionCallback() {

        $model = new Callback();
        $model->setScenario(Callback::SCENARIO_SITE);
        
        $_RESULT = ['status' => Statuses::STATUS_ERROR];

        if (Yii::$app->request->post('Callback')) {
            
            $model->load(Yii::$app->request->post());
            $model->captcha = Yii::$app->request->post(ReCaptcha::FIELD_NAME);
    
            if ($model->validate()) {
                $model->save(false);
                
                $_RESULT['status'] = Statuses::STATUS_OK;
                $_RESULT['message'] = Yii::$app->vars->val(163);
            } else {
                $_RESULT['error'] = $model->getErrors();
            }
        }

        echo Json::encode($_RESULT);
    }

    public function actionPage($alias, $id = 0) {

        $page = Pages::find()->where(['alias' => $alias])->one();

        if (!$page) {
            $page = Pages::find()->where(['alias_new' => $alias])->one();
        } else {
            // редирект на новую страницу
            if ($page->alias_new) {
                $this->redirect([Normalize::fixAlias($page->alias_new)], 301);
                Yii::$app->end();
            }
        }

        if ($page) {
            if (strpos(Yii::$app->request->url, '.php')) {
                $this->redirect([Normalize::fixAlias($page->alias)], 301);
                Yii::$app->end();
            }

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

                    case Pages::WHY_US_ID:
                        return $this->actionWhyUs();
                        break;

                    case Pages::OUR_MADE_ID:
                        return $this->actionOurMade();
                        break;

                    case Pages::ORDER_ID_AQUA:
                        return $this->actionOrder();
                        break;

                    case Pages::SEARCH_ID :
                        return $this->actionSearch();
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

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        if ($exception !== null) {
            return $this->render('error', ['exception' => $exception]);
        }
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
