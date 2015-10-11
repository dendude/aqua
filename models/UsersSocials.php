<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users_socials}}".
 *
 * @property integer $id
 * @property integer $id_provider
 * @property string $id_account
 * @property integer $id_user
 * @property string $first_name
 * @property string $last_name
 * @property string $email
 * @property string $photo100
 * @property integer $created
 */
class UsersSocials extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_socials}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_provider', 'id_account', 'id_user', 'first_name', 'last_name', 'email', 'photo100', 'created'], 'required'],
            [['id_provider', 'id_account', 'id_user', 'created'], 'integer'],
            [['first_name', 'last_name', 'email', 'photo100'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_provider' => 'Id Provider',
            'id_account' => 'Id Account',
            'id_user' => 'Id User',
            'first_name' => 'First Name',
            'last_name' => 'Last Name',
            'email' => 'Email',
            'photo100' => 'Photo100',
            'created' => 'Created',
        ];
    }
}
