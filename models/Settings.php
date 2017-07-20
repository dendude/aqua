<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%settings}}".
 *
 * @property integer $id
 * @property integer $id_author
 * @property string $email_username
 * @property string $email_password
 * @property string $email_host
 * @property integer $email_port
 * @property string $email_fromname
 * @property integer $created
 * @property double $ex_eur
 */
class Settings extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%settings}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_author', 'email_username', 'email_password', 'email_host', 'email_port', 'email_fromname', 'email_sign', 'created'], 'required'],
            [['id_author', 'email_port', 'created'], 'integer'],
            [['email_username', 'email_password', 'email_host', 'email_fromname'], 'string', 'max' => 100],
            [['email_sign'], 'string'],
            [['recievers'], 'string', 'max' => 1000]
        ];
    }

    public function beforeValidate()
    {
        $this->id_author = Yii::$app->user->id;
        $this->created = time();

        return parent::beforeValidate();
    }

    public static function lastSettings() {
        return self::find()->count() ? self::find()->orderBy(['id' => SORT_DESC])->one() : new Settings();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'recievers' => 'Получатели писем с сайта',
            'id_author' => 'Id Author',
            'email_username' => 'Email-пользователь',
            'email_password' => 'Email-пароль',
            'email_host' => 'Email-хост',
            'email_port' => 'Email-порт',
            'email_fromname' => 'Отправитель писем',
            'email_sign' => 'Подпись отправляемых писем',
            'created' => 'Created',
        ];
    }
}
