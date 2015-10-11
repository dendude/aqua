<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%users_socials_providers}}".
 *
 * @property integer $id
 * @property string $name
 * @property string $app_id
 * @property string $app_key
 * @property string $ulink
 */
class UsersSocialsProviders extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%users_socials_providers}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'app_id', 'app_key', 'ulink'], 'required'],
            [['app_id'], 'integer'],
            [['name', 'app_key', 'ulink'], 'string', 'max' => 100]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'app_id' => 'App ID',
            'app_key' => 'App Key',
            'ulink' => 'Ulink',
        ];
    }
}
