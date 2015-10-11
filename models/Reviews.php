<?php

namespace app\models;

use app\components\SmtpEmail;
use app\helpers\Statuses;
use Yii;

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
class Reviews extends \yii\db\ActiveRecord
{
    const PAGE_ID = 164;
    const PAGE_ADD_ID = 178;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%reviews}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'email', 'comment'], 'required'],

            [['email'], 'email'],

            [['manager_id', 'user_id', 'created', 'modified', 'status', 'ordering', 'published', 'send_mail'], 'integer'],
            [['manager_id', 'user_id', 'created', 'modified', 'status', 'ordering', 'published', 'send_mail'], 'default', 'value' => 0],

            [['comment'], 'string'],
            [['name', 'email'], 'string', 'max' => 100]
        ];
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
        }

        return parent::beforeValidate();
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {
            // просто сохраняем
        } else {
            $self = self::findOne($this->id);
            // отправляем письмо один раз
            if ($this->send_mail && $self->send_mail == Statuses::STATUS_DISABLED) {
                $smtp = new SmtpEmail();
                $smtp->sendEmailByType(SmtpEmail::TYPE_REVIEW_NOTIFICATION, $this->email, $this->name, ['{review_text}' => $this->comment]);
            } else {
                $this->send_mail = $self->send_mail;
            }

            if ($this->status && !$this->published) {
                $this->published = time();
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
            'user_id' => 'Id User',
            'name' => 'Имя',
            'email' => 'Email',
            'comment' => 'Отзыв',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'published' => 'Опубликован',
            'ordering' => 'Порядок',
            'status' => 'Статус',
            'send_mail' => 'Уведомлен',
        ];
    }
}
