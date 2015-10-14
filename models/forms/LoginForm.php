<?php

namespace app\models\forms;

use app\helpers\Statuses;
use app\models\Users;
use Yii;
use yii\base\Model;

class LoginForm extends Model
{
    public $email;
    public $password;

    private $_user = false;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'password'], 'required'],
            ['email', 'trim'],

            ['email', 'email'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Пользователь не найден. Проверьте логин и пароль');
            }
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            $user->setVisit();

            return Yii::$app->user->login($user, 3600*24*30);
        }
        return false;
    }

    public function getUser()
    {
        if ($this->_user === false) {
            $this->_user = Users::find()->where(['email' => $this->email, 'status' => Statuses::STATUS_ACTIVE])->one();
        }

        return $this->_user;
    }

    public function attributeLabels() {
        return [
            'email' => 'Email',
            'password' => 'Пароль',
        ];
    }
}
