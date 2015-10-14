<?php

namespace app\models;

use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%vars}}".
 *
 * @property integer $id
 * @property string $value
 */
class Vars extends \yii\db\ActiveRecord
{
    const CACHE_NAME = 'vars';
    const SESSION_NAME = 'show_vars';

    protected static $cache_list = [];
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%vars}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['value'], 'required'],
            [['created', 'modified'], 'integer'],
            [['created', 'modified'], 'default', 'value' => 0],
            [['value'], 'string']
        ];
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->modified = time();
        }
        return parent::beforeValidate(); // TODO: Change the autogenerated stub
    }

    public function afterSave($insert, $changedAttributes) {
        // обновляем кеш
        $list = self::find()->all();
        $vars = ArrayHelper::map($list, 'id', 'value');
        Yii::$app->cache->set(self::CACHE_NAME, $vars);

        parent::afterSave($insert, $changedAttributes);
    }

    public static function val($id) {

        if (empty(self::$cache_list)) {
            // получаем кеш
            $cache = Yii::$app->cache;

            if ($cache->offsetExists(self::CACHE_NAME)) {
                // кеш уже существует
                $vars = $cache->get(self::CACHE_NAME);
            } else {
                // один запрос для кеша
                $list = self::find()->all();
                $vars = ArrayHelper::map($list, 'id', 'value');
                $cache->set(self::CACHE_NAME, $vars);
            }
            // сохраняем в статику
            self::$cache_list = $vars;
        }

        // учитывается режим показа названий переменных
        return Yii::$app->session->get(self::SESSION_NAME) ? 'Msg_' . sprintf('%04d', $id) : nl2br(self::$cache_list[$id]);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'value' => 'Value',
            'created' => 'Value',
            'modified' => 'Value',
        ];
    }
}