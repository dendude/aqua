<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%email_templates}}".
 *
 * @property integer $id
 * @property integer $id_author
 * @property string $subject
 * @property string $content
 * @property integer $created
 * @property integer $modified
 */
class EmailTemplates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%email_templates}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_author', 'subject', 'content', 'created'], 'required'],
            [['id_author', 'created', 'modified'], 'integer'],
            [['id_author', 'created', 'modified'], 'default', 'value' => 0],
            [['content'], 'string'],
            [['subject'], 'string', 'max' => 200]
        ];
    }

    public function getAuthor() {
        return $this->hasOne(Users::className(), ['id' => 'id_author']);
    }

    public function beforeValidate()
    {
        $this->id_author = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->modified = time();
        }
        return parent::beforeValidate();
    }

    public static function getFilterList() {
        $list = self::find()->orderBy(['ordering' => SORT_ASC])->all();
        return $list ? ArrayHelper::map($list, 'id', 'subject') : [];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_author' => 'Менеджер',
            'subject' => 'Тема письма',
            'content' => 'Шаблон письма',
            'created' => 'Создан',
            'modified' => 'Изменен',
        ];
    }
}
