<?php

namespace app\models\forms;

use app\components\SmtpEmail;
use app\models\Users;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;

class RegisterForm extends Model
{
    public $name;
    public $email;
    public $password;
    public $password2;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'password', 'password2'], 'required'],
            [['name', 'email'], 'trim'],

            ['email', 'email'],
            ['email', 'unique', 'targetClass' => '\app\models\Users', 'message' => 'Такой Email уже зарегистрирован на сайте'],

            [['password','password2'], 'string', 'min' => 6, 'tooShort' => 'Введите не менее {min} символов'],
            ['password2', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли должны совпадать'],
        ];
    }

    public function register()
    {
        $user = new Users();
        $user->attributes = $this->attributes;
        $user->pass = $this->password;

        if ($user->save()) {
            $smtp = new SmtpEmail();
            if ($smtp->sendEmailByType(SmtpEmail::TYPE_REGISTER,
                                        $user->email,
                                        $user->name,
                                        ['{link}' => Yii::$app->params['sitename'] . Url::to(['/auth/activate', 'id' => $user->id, 'code' => $user->code])])) {
                return true;
            } else {
                $user->delete();
            }
        }

        return false;
    }

    public function attributeLabels() {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш Email',
            'password' => 'Пароль для входа',
            'password2' => 'Повторите пароль',
        ];
    }
}
