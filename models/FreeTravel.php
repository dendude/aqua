<?php

namespace app\models;

use app\components\ReCaptcha;
use app\components\SmtpEmail;
use app\helpers\Normalize;
use app\helpers\Statuses;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%reviews}}".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property string $email
 * @property string $comment
 * @property integer $created
 * @property integer $status
 */
class FreeTravel extends ActiveRecord
{
    const PAGE_ID = 182;
    
    public $captcha;
    
    const SCENARIO_SITE = 'site';

    public static function tableName()
    {
        return '{{%free_travel}}';
    }

    public function rules()
    {
        return [
            [['name', 'phone', 'email'], 'required'],

            [['email'], 'email'],

            [['manager_id', 'created', 'modified', 'processed', 'status'], 'integer'],
            [['manager_id', 'created', 'modified', 'processed', 'status'], 'default', 'value' => 0],

            [['phone', 'comment'], 'string', 'min' => 10, 'tooShort' => 'Введите не менее {min} символов'],
            [['name', 'email', 'phone'], 'string', 'max' => 100],

            ['captcha', 'required', 'message' => 'Необходимо отметить поле "Я не робот"', 'on' => self::SCENARIO_SITE],
            ['captcha', 'checkCaptcha', 'on' => self::SCENARIO_SITE],
        ];
    }
    
    public function checkCaptcha($attribute, $params) {
        $re_captcha = new ReCaptcha($this->{$attribute});
        if (!$re_captcha->validate()) {
            $this->addError($attribute, 'Некорректное значение reCaptcha');
        }
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->manager_id = Yii::$app->user->id;
            $this->modified = time();

            if ($this->status == Statuses::STATUS_ACTIVE) {
                $this->processed = time();
            } else {
                $this->processed = 0;
            }
        }

        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            // отправляем письмо один раз
            $smtp = new SmtpEmail();
            $smtp->sendEmailByType(SmtpEmail::TYPE_FREE_TRAVEL, $this->email, $this->name, [
                '{name}' => $this->name,
                '{phone}' => $this->phone,
                '{email}' => $this->email,
                '{comment}' => (!empty($this->comment) ? nl2br($this->comment) : 'Не указан'),
            ]);
        }

        return parent::save($runValidation, $attributeNames);
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Менеджер',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'processed' => 'Обработан',
            'status' => 'Статус',
        ];
    }
}
