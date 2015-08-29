<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class Users extends \yii\db\ActiveRecord implements \yii\web\IdentityInterface {

    public $authKey;
    public $username;

    static $profile;

    const ROLE_MANAGER = 'manager';

    public static function tableName()
    {
        return '{{%users}}';
    }

    public function rules()
    {
        return [
            [['loc_country', 'loc_region', 'loc_city', 'created', 'modified'], 'integer'],
            [['points_get', 'points_use', 'visits', 'last_visit'], 'integer'],
            [['count_ads', 'count_fav', 'count_sbr','installed'], 'integer'],
            [['role', 'full_name', 'photo_50'], 'string'],
            [['is_blacklist'], 'boolean'],

            [['loc_country', 'loc_region', 'loc_city', 'created', 'modified','installed'], 'default', 'value' => 0],
            [['points_get', 'points_use', 'visits', 'last_visit'], 'default', 'value' => 0],
            [['count_ads', 'count_fav', 'count_sbr'], 'default', 'value' => 0],
        ];
    }

    public static function getManagersList($role = self::ROLE_MANAGER) {
        $managers = self::find()->where(['role' => $role])->all();
        return $managers ? ArrayHelper::map($managers, 'id', 'full_name') : [];
    }
    public static function getManagerName($user_id) {
        $list = self::getManagersList();
        return isset($list[$user_id]) ? $list[$user_id] : 'Не найден';
    }
    public static function isManager($user_id = null) {
        $list = self::getManagersList();
        return $user_id ? isset($list[$user_id]) : isset($list[Yii::$app->user->id]);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->modified = time();
        }
        return parent::beforeValidate();
    }

    public function setVisits() {
        $this->updateAttributes(['last_visit' => time()]);
        $this->updateCounters(['visits' => 1]);
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

    public function attributeLabels()
    {
        return [
            'id' => 'ID',

            'role' => 'Роль',
            'full_name' => 'Полное имя',

            'created' => 'Создан',
            'modified' => 'Изменён',
            'visits' => 'Визитов',
            'last_visit' => 'Посл.визит',
        ];
    }
}
