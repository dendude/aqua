<?php

namespace app\models;

use app\components\SmtpEmail;
use app\helpers\Statuses;
use Yii;

/**
 * This is the model class for table "{{%feedback}}".
 *
 * @property integer $id
 * @property integer $id_user
 * @property string $name
 * @property string $email
 * @property string $phone
 * @property string $subject
 * @property string $message
 * @property integer $created
 * @property integer $status
 */
class Calculate extends \yii\db\ActiveRecord
{
    const PAGE_ID = 183;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%calculate}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'message'], 'required'],
            [['answer'], 'required', 'when' => function($model){
                return $model->status == Statuses::STATUS_ACTIVE;
            }, 'message' => 'Чтобы отправить {attribute}, необходимо заполнить его'],

            [['manager_id', 'created', 'modified', 'answered', 'status'], 'integer'],
            [['manager_id', 'created', 'modified', 'answered', 'status'], 'default', 'value' => 0],

            [['email'], 'email'],

            [['message', 'answer'], 'string'],
            [['message', 'answer'], 'default', 'value' => ''],

            [['name', 'email'], 'string', 'max' => 100],
            [['name', 'email'], 'default', 'value' => ''],

            [['phone'], 'string', 'max' => 20],
            [['phone'], 'default', 'value' => ''],
        ];
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
                $this->answered = time();
            }
        }

        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {

        } else {
            $self = self::findOne($this->id);
            // отправляем письмо один раз
            if ($this->status == Statuses::STATUS_ACTIVE) {
                $smtp = new SmtpEmail();
                $smtp->sendEmailByType(SmtpEmail::TYPE_ANSWER_QUESTION, $this->email, $this->name, [
                    '{question_text}' => $this->message,
                    '{answer_text}' => $this->answer,
                ]);
            } else {
                $this->status = $self->status;
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
            'email' => 'Email',
            'phone' => 'Телефон',
            'message' => 'Сообщение',
            'answer' => 'Ответ',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'answered' => 'Отвечен',
            'status' => 'Статус',
        ];
    }
}
