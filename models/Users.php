<?php

namespace app\models;

use app\components\SmtpEmail;
use app\helpers\Statuses;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public $authKey;
    public $username;

    protected $is_empty_pass = false;

    static $profile;

    const ROLE_USER = 'user';
    const ROLE_MANAGER = 'manager';
    const ROLE_ADMIN = 'admin';

    public static function tableName()
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['name', 'email', 'pass'], 'required'],

            [['email'], 'email'],
            [['email'], 'unique'],

            [['role', 'name', 'email', 'pass', 'code', 'phone'], 'string'],
            [['created', 'modified', 'last_visit', 'status'], 'integer'],

            [['role'], 'default', 'value' => self::ROLE_USER],
            [['name', 'email', 'pass', 'code', 'phone'], 'default', 'value' => ''],
            [['created', 'modified', 'last_visit', 'status'], 'default', 'value' => 0],

            ['phone', 'cleanPhone'],
        ];
    }

    public function cleanPhone($attribute, $params){
        $this->$attribute = preg_replace('/[^0-9]+/','',$this->$attribute);
    }

    public static function getRoles() {

        return [
            self::ROLE_USER => 'User',
            self::ROLE_MANAGER => 'Manager',
            self::ROLE_ADMIN => 'Admin',
        ];
    }

    public static function getRolesNames() {

        return [
            self::ROLE_USER => 'Пользователь',
            self::ROLE_MANAGER => 'Менеджер',
            self::ROLE_ADMIN => 'Администратор',
        ];
    }

    public function getRoleName() {

        $roles = self::getRolesNames();
        return isset($roles[$this->role]) ? $roles[$this->role] : 'not found';
    }

    public static function getManagersList() {
        return self::find()->where(['role' => 'manager'])->all();
    }

    public static function isAdmin() {
        $self = self::findOne(Yii::$app->user->id);
        return ($self->role == self::ROLE_ADMIN);
    }

    public static function isManager() {
        if (Yii::$app->user->isGuest) return false;

        $self = self::findOne(Yii::$app->user->id);
        return in_array($self->role, [self::ROLE_MANAGER, self::ROLE_ADMIN]);
    }

    public static function getManagers() {
        $list = self::find()->where(['role' => [self::ROLE_MANAGER, self::ROLE_ADMIN]])->orderBy('name ASC')->all();
        return $list ? ArrayHelper::map($list, 'id', 'name') : [];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->role = self::ROLE_USER;
            $this->code = Yii::$app->security->generateRandomString(50);
            $this->created = time();
        } else {
            $this->modified = time();
            if (empty($this->pass)) {
                $self = Users::findOne($this->id);
                $this->pass = $self->pass;
                $this->is_empty_pass = true;
            }
        }

        return parent::beforeValidate();
    }

    public function beforeSave($insert)
    {
        if ($this->pass && !$this->is_empty_pass) {
            $this->pass = Yii::$app->security->generatePasswordHash($this->pass);
        }

        if (!$this->isNewRecord && !self::isAdmin()) {
            $self = self::findOne($this->id);
            $this->role = $self->role;
        }

        return parent::beforeSave($insert);
    }

    public function afterSave($insert, $changedAttributes)
    {
        if (Users::isManager() && $this->id != Yii::$app->user->id && $this->status == Statuses::STATUS_DISABLED) {
            // отправляем письмо, если добавлен из админки и не был активирован
            $smtp = new SmtpEmail();
            $smtp->sendEmailByType(
                SmtpEmail::TYPE_REGISTER,
                $this->email,
                $this->name,
                ['{link}' => Url::to(['/auth/activate', 'id' => $this->id, 'code' => $this->code], true)]
            );
        }

        parent::afterSave($insert, $changedAttributes);
    }

    public function setVisit() {
        $this->updateAttributes(['last_visit' => time()]);
    }

    public static function selfProfile() {
        return self::findIdentity(Yii::$app->user->id);
    }

    /** identity methods */
    public static function findIdentity($id)
    {
        if (!self::$profile) {
            self::$profile = static::findOne($id);
        }
        return self::$profile;
    }
    public static function findIdentityByAccessToken($token, $type = null)
    {
        return static::findOne(['access_token' => $token]);
    }
    public function getId()
    {
        return $this->id;
    }
    public function getAuthKey()
    {
        return $this->authKey;
    }
    public function validateAuthKey($authKey)
    {
        return ($this->authKey === $authKey);
    }

    public function validatePassword($password)    {
        return Yii::$app->security->validatePassword($password, $this->pass);
    }

    public function getBalance() {
        return ($this->points_get - $this->points_use);
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'role' => 'Роль',
            'name' => 'Имя',
            'email' => 'Email',
            'pass' => 'Пароль',
            'phone' => 'Телефон',

            'created' => 'Создан',
            'modified' => 'Изменён',
            'last_visit' => 'Посл.визит',

            'status' => 'Статус',
        ];
    }
}