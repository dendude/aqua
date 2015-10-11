<?php

namespace app\controllers;

use app\components\SmtpEmail;
use app\helpers\Statuses;
use app\models\forms\ForgotForm;
use app\models\forms\RegisterForm;
use app\models\Users;
use app\models\Vars;
use app\widgets\ModalLogin;
use app\widgets\ModalRegister;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Html;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\forms\LoginForm;

class AuthController extends Controller
{
    public $breadcrumbs = [];

    public function beforeAction($action)
    {
        if (!Yii::$app->user->isGuest) {
            $this->redirect(Yii::$app->homeUrl)->send();
        }

        return parent::beforeAction($action);
    }


    public function actionLogin() {

        $model = new LoginForm();
        $model->attributes = Yii::$app->request->post('LoginForm');
        if ($model->validate() && $model->login()) {
            echo Json::encode(['role' => Yii::$app->user->identity->role, 'url' => Url::to(['/admin/default/index'])]);
        } else {
            echo Json::encode(['content' => ModalLogin::widget(['model' => $model])]);
        }
    }

    public function actionRegister() {

        $model = new RegisterForm();
        $result = null;

        if (Yii::$app->request->post('RegisterForm')) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->register()) {
                $result = Yii::$app->vars->val(38);
            }
        }

        return $this->render('register',[
            'model' => $model,
            'result' => $result
        ]);
    }

    public function actionActivate($id = 0) {

        $user_code = Yii::$app->request->get('code');

        $msg = [Yii::$app->vars->val(39)];
        $class = 'danger';

        if ($id && $user_code) {

            $user = Users::findOne($id);
            if ($user) {
                if ($user->code === $user_code) {

                    $class = 'ok'; // не окрашиваем стиль

                    if ($user->status == Statuses::STATUS_ACTIVE) {
                        $msg = [Yii::$app->vars->val(40)];
                    } else {
                        $msg = [Yii::$app->vars->val(41)];
                        $user->status = Statuses::STATUS_ACTIVE;
                        $user->save();
                    }

                    $msg[] = Yii::$app->vars->val(42) . ' ' . Html::a(Yii::$app->vars->val(43), '#', ['onclick' => "$('#login_link').click()"]) ;

                } else {
                    $msg[] = Yii::$app->vars->val(44);
                }
            } else {
                $msg[] = Yii::$app->vars->val(44);
            }
        } else {
            $msg[] = Yii::$app->vars->val(45);
        }

        return $this->render('activate',[
            'message' => implode('<br />', $msg),
            'class' => $class
        ]);
    }

    public function actionForgot() {

        $model = new ForgotForm();
        $result = null;

        if (Yii::$app->request->post('ForgotForm')) {
            $model->load(Yii::$app->request->post());

            if ($model->validate() && $model->restore()) {
                $result = Yii::$app->vars->val(46);
            }
        }

        return $this->render('forgot',[
            'model' => $model,
            'result' => $result
        ]);
    }

    public function actionRestore($id = 0) {

        $user_code = Yii::$app->request->get('code');

        $msg = [Yii::$app->vars->val(39)];
        $class = 'danger';

        if ($id && $user_code) {

            $user = Users::findOne($id);
            if ($user) {
                if ($user->code === $user_code) {

                    $new_pass = substr(md5(time()), 0, 10);

                    $user->updateAttributes(['code' => '',
                                             'pass' => Yii::$app->security->generatePasswordHash($new_pass)]);

                    $smtp = new SmtpEmail();
                    $smtp->sendEmailByType(SmtpEmail::TYPE_NEW_PASSWORD, $user->email, $user->name, ['{password}' => $new_pass]);

                    $class = 'ok'; // не окрашиваем стиль

                    $msg = [Yii::$app->vars->val(47)];
                    $msg[] = Yii::$app->vars->val(42)
                        . ' ' . Html::a(Yii::$app->vars->val(43), '#', ['onclick' => "$('#login_link').click()"])
                        . ', ' . Yii::$app->vars->val(48);

                } else {
                    $msg[] = Yii::$app->vars->val(49);
                }
            } else {
                $msg[] = Yii::$app->vars->val(49);
            }
        } else {
            $msg[] = Yii::$app->vars->val(50);
        }

        return $this->render('restore',[
            'message' => implode('<br />', $msg),
            'class' => $class
        ]);
    }

    public function actionLogout() {
        Yii::$app->user->logout();
        Yii::$app->session->offsetUnset(Vars::SESSION_NAME);
        return $this->goHome();
    }
}
