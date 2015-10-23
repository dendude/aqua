<?php

namespace app\models;

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
class Callback extends \yii\db\ActiveRecord
{
    const PAGE_ID = 184;

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

            [['email'], 'email'],

            [['manager_id', 'created', 'modified', 'processed', 'status'], 'integer'],
            [['manager_id', 'created', 'modified', 'processed', 'status'], 'default', 'value' => 0],

            [['comment', 'subject'], 'string'],
            [['comment', 'subject'], 'default', 'value' => ''],

            [['name', 'email', 'phone', 'subject'], 'string', 'max' => 100]
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
                $this->processed = time();
            } else {
                $this->processed = 0;
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
            'manager_id' => 'Менеджер',
            'name' => 'Имя',
            'email' => 'Email',
            'phone' => 'Телефон',
            'subject' => 'Тема',
            'comment' => 'Комментарий',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'processed' => 'Обработан',
            'status' => 'Статус',
        ];
    }
}
