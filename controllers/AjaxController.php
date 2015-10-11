<?php
/**
 * Created by PhpStorm.
 * User: dendude
 * Date: 09.03.15
 * Time: 21:55
 */

namespace app\controllers;

use app\models\Actions;
use app\models\Ads;
use app\models\forms\UploadForm;
use app\models\Users;
use app\models\UsersRecommends;
use app\models\UsersSubscribes;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\helpers\Json;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use yii\helpers\Html;

use app\helpers\Normalize;
use app\models\Fields;
use yii\web\HttpException;

class AjaxController extends Controller {

    public function actionAlias() {

        if (Yii::$app->request->isAjax && !empty($_POST['str'])) {
            $alias = trim($_POST['str']);
            echo Normalize::alias($alias);
        }
    }
} 
