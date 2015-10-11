<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

class NewsSections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%news_sections}}'; 
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'name'], 'required'],
            [['manager_id', 'ordering', 'created', 'modified', 'status'], 'integer'],
            [['manager_id', 'ordering', 'created', 'modified', 'status'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 100]
        ];
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function getNews() {
        return $this->hasMany(News::className(), ['section_id' => 'id']);
    }

    public function beforeValidate()
    {
        $this->manager_id = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->modified = time();
        }
        return parent::beforeValidate();
    }

    public static function getFilterList() {
        $list = self::find()->orderBy(['ordering' => SORT_ASC])->all();
        return $list ? ArrayHelper::map($list, 'id', 'name') : [];
    }

    public function afterDelete()
    {
        // удаляем вложенные вопросы
        News::deleteAll(['section_id' => $this->id]);
        parent::afterDelete();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Менеджер',
            'name' => 'Название',
            'ordering' => 'Порядок',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'status' => 'Статус',
        ];
    }
}
