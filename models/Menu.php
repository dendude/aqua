<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "{{%menu}}".
 *
 * @property integer $id
 * @property integer $id_author
 * @property integer $parent_id
 * @property integer $page_id
 * @property string $menu_name
 * @property string $menu_title
 * @property integer $ordering
 * @property integer $status
 */
class Menu extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%menu}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id_author', 'parent_id', 'menu_name', 'created'], 'required'],
            [['id_author', 'parent_id', 'page_id', 'ordering', 'status', 'created'], 'integer'],
            [['id_author', 'parent_id', 'page_id', 'ordering', 'status', 'created'], 'default', 'value' => 0],
            [['menu_name', 'menu_title'], 'string', 'max' => 100]
        ];
    }

    public static function find() {
        return new MenuQuery(get_called_class());
    }

    public function getPage() {
        return $this->hasOne(Pages::className(), ['id' => 'page_id']);
    }

    public function getParent() {
        return $this->hasOne(Menu::className(), ['id' => 'parent_id']);
    }

    public function getChilds() {
        return $this->hasMany(Menu::className(), ['parent_id' => 'id']);
    }

    public function beforeValidate()
    {
        $this->id_author = Yii::$app->user->id;
        if ($this->isNewRecord) {
            $this->created = time();
            // выбираем максимальное значение порядка
            $max_ord = (int) self::find()->where(['parent_id' => $this->parent_id])->max('ordering');
            $this->ordering = ($max_ord + 1);
        }

        return parent::beforeValidate();
    }


    public function beforeSave($insert)
    {
        if ($this->isNewRecord) {
            // выбираем максимальное значение порядка
            $max_ord = (int) self::find()->where(['parent_id' => $this->parent_id])->max('ordering');
            $this->ordering = ($max_ord + 1);
        }

        return parent::beforeSave($insert);
    }


    public static function getFilterList($only_parents = false) {
        $list = [];

        foreach (self::find()->root()->orderBy('ordering ASC')->all() AS $menu_item) {
            $list[$menu_item->id] = $menu_item->menu_name;

            $childs = self::find()->where(['parent_id' => $menu_item->id])->orderBy('ordering ASC')->all();
            if ($childs) {
                foreach ($childs AS $child_item) {
                    $list[$child_item->id] = '&nbsp;&nbsp;&nbsp;' . $child_item->menu_name;

                    if ($only_parents) continue;

                    $subchilds = self::find()->where(['parent_id' => $child_item->id])->orderBy('ordering ASC')->all();
                    if ($subchilds) {
                        foreach ($subchilds AS $subchild_item) {
                            $list[$subchild_item->id] = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;' . $subchild_item->menu_name;
                        }
                    }
                }
            }
        }

        return $list;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'id_author' => 'Автор',
            'parent_id' => 'Родительский пункт меню',
            'page_id' => 'Прикрепленная страница',
            'menu_name' => 'Название пункта меню',
            'menu_title' => 'Подсказка меню',
            'ordering' => 'Порядок',
            'status' => 'Опубликовать',
        ];
    }
}
