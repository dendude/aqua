<?php

namespace app\models\forms;

use app\components\SmtpEmail;
use app\helpers\Statuses;
use app\models\Users;
use Yii;
use yii\base\Model;
use yii\helpers\Url;

class ForgotForm extends Model
{
    public $name;
    public $email;

    private $_user;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email','name'], 'required'],
            [['email','name'], 'trim'],
            [['email'], 'email'],
            [['email'], 'checkEmail'],
        ];
    }

    public function checkEmail($attribute, $params) {

        $user = Users::find()->where(['email' => $this->$attribute])->one();
        if ($user) {
            if ($user->status == Statuses::STATUS_ACTIVE) {
                $this->_user = $user;
            } else {
                $this->addError($attribute, 'Ваша учетная запись не активирована. Для активации пройдите по ссылке, которая была отправлена при регистрации');
            }
        } else {
            $this->addError($attribute, 'Такой Email не зарегистрирован на сайте');
        }
    }

    public function restore()
    {
        $code = Yii::$app->security->generateRandomString(50);
        $this->_user->updateAttributes(['code' => $code]);

        $smtp = new SmtpEmail();
        return $smtp->sendEmailByType(
            SmtpEmail::TYPE_RESTORE,
            $this->email,
            $this->name,
            ['{link}' => Yii::$app->params['sitename'] . Url::to(['/auth/restore', 'id' => $this->_user->id, 'code' => $code])]
        );
    }

    public function attributeLabels() {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш Email',
        ];
    }
}
