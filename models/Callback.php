<?php

namespace app\models;

use app\components\ReCaptcha;
use app\components\SmtpEmail;
use app\helpers\Statuses;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%reviews}}".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property string $comment
 * @property integer $created
 * @property integer $status
 */
class Callback extends ActiveRecord
{
    const PAGE_ID = 184;
    
    const SCENARIO_SITE = 'site';
    
    public $captcha;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%callback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'phone'], 'required'],

            [['manager_id', 'created', 'modified', 'processed', 'status'], 'integer'],
            [['manager_id', 'created', 'modified', 'processed', 'status'], 'default', 'value' => 0],

            [['comment'], 'string'],
            [['comment'], 'default', 'value' => ''],

            [['name', 'phone'], 'string', 'max' => 100],

            [['phone'], 'string', 'min' => 10, 'max' => 20],
            [['phone'], 'default', 'value' => ''],
            
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
            // отправка писем менеджерам
            $settings = Settings::lastSettings();
            $recievers = explode(PHP_EOL, $settings->recievers);

            $params = ['{name}' => $this->name,
                      '{phone}' => $this->phone,
                    '{comment}' => nl2br($this->comment)];

            $smtp = new SmtpEmail();
            foreach ($recievers AS $r) {
                $smtp->sendEmailByType(SmtpEmail::TYPE_CALLBACK, trim($r), 'Менеджер', $params, false);
            }
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
            'phone' => 'Телефон',
            'comment' => 'Комментарий',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'processed' => 'Обработан',
            'status' => 'Статус',
        ];
    }
}
