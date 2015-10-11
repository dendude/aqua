<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%faq_sections}}".
 *
 * @property integer $id
 * @property integer $author_id
 * @property string $name
 * @property integer $ordering
 * @property integer $created
 * @property integer $status
 */
class FaqSections extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faq_sections}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['author_id', 'name'], 'required'],
            [['author_id', 'ordering', 'created', 'status', 'modified'], 'integer'],
            [['author_id', 'ordering', 'created', 'status', 'modified'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 100]
        ];
    }

    public function getAuthor() {
        return $this->hasOne(Users::className(), ['id' => 'author_id']);
    }

    public function getQuestions() {
        return $this->hasMany(Faq::className(), ['section_id' => 'id']);
    }

    public function beforeValidate()
    {
        $this->author_id = Yii::$app->user->id;
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
        Faq::deleteAll(['section_id' => $this->id]);
        parent::afterDelete();
    }


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'author_id' => 'Автор',
            'name' => 'Название',
            'ordering' => 'Порядок',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'status' => 'Статус',
        ];
    }
}
