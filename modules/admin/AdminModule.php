<?php

namespace app\modules\admin;

use app\models\Users;
use Yii;
use yii\helpers\Url;

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
        Yii::$app->errorHandler->errorAction = 'admin/default/error';
    }

    public function beforeAction($action)
    {
        if (parent::beforeAction($action)) {

            if (Yii::$app->user->id && in_array(Yii::$app->user->identity->role, [Users::ROLE_ADMIN, Users::ROLE_MANAGER])) {

                // если уже авторизован - направляем в кабинет
                if ($action->id == 'login') {
                    Yii::$app->response->redirect(Url::to(['index']))->send();
                }

            } elseif ($action->id != 'login') {
                // неавторизован и не на странице входа - перенаправляем на страницу входа
                Yii::$app->response->redirect(Yii::$app->homeUrl)->send();
                return false;
            }

        } else {
            return false;
        }

        return true;
    }
}
