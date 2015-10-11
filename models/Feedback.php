<?php

namespace app\models;

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
class Feedback extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%feedback}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'phone', 'subject', 'message'], 'required'],
            [['manager_id', 'user_id', 'created', 'modified', 'answered', 'status'], 'integer'],

            [['email'], 'email'],

            [['message', 'answer'], 'string'],
            [['name', 'email', 'subject'], 'string', 'max' => 100],
            [['phone'], 'string', 'max' => 20],

            ['answer', 'checkAnswer'],
        ];
    }

    public function checkAnswer($attribute, $params) {
        if ($this->status == Statuses::STATUS_ACTIVE && empty($this->answer)) {
            $this->addError($attribute, 'Чтобы отправить Ответ пользователю, необходимо заполнить его');
        }
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = time();
            if (!Yii::$app->user->isGuest) {
                $this->user_id = Yii::$app->user->id;
            }
        } else {
            $this->manager_id = Yii::$app->user->id;
            $this->modified = time();
            if ($this->status == Statuses::STATUS_ACTIVE) {
                $this->answered = time();
            }
        }

        return parent::beforeValidate();
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User Id',
            'manager_id' => 'Менеджер',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'subject' => 'Тема',
            'message' => 'Сообщение',
            'answer' => 'Ответ',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'answered' => 'Отвечен',
            'status' => 'Статус',
        ];
    }
}
