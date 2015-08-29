<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * авторизация пользователя в приложении
 * @author DenDude
 */
class UserAuth extends Model {

    public $username;
    public $password;

    private $_user = null;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            [['username', 'password'], 'string'],

            ['password', 'validateAuthKey'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validateAuthKey($attribute, $params)
    {
        if (!$this->hasErrors()) {

            $user = Users::find()->where(['login' => $this->username])->one();
            if ($user) {
                if (Yii::$app->getSecurity()->validatePassword($this->password, $user->password)) {
                    $this->_user = $user;
                }
            }

            $this->addError('', 'Пользователь не найден. Проверьте логин и пароль');
        }
    }

    /**
     * Logs in a user using the provided username and password.
     * @return boolean whether the user is logged in successfully
     */
    public function login() {

        if (!Yii::$app->user->isGuest) {
            Yii::$app->user->logout();
        }

        return Yii::$app->user->login($this->_user, Yii::$app->params['userCookieTime']);
    }
}