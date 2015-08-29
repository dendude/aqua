<?php

namespace app\modules\admin;

use Yii;
use yii\helpers\Url;
use app\models\Users;

class AdminModule extends \yii\base\Module
{
    public $controllerNamespace = 'app\modules\admin\controllers';

    public $defaultRoute = 'main';
    public $defaultAction = 'index';

    public function init()
    {
        parent::init();

        $this->layoutPath = Yii::$app->layoutPath;
        $this->layout = 'admin';
        Yii::$app->errorHandler->errorAction = 'admin/main/error';
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            if (Users::isManager()) {
                // если уже авторизован - направляем в кабинет
                if ($action->id == 'login') {
                    Yii::$app->response->redirect(Url::to(['main/index']))->send();
                }
            } elseif ($action->id != 'login') {
                // неавторизован и не на странице входа - перенаправляем на страницу входа
                Yii::$app->response->redirect(Url::to(['main/login']))->send();
            }

        } else {
            return false;
        }

        return true;
    }
}
