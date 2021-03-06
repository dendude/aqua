<?php

namespace app\models;

use app\helpers\Statuses;
use Yii;
use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "{{%photo_albums}}".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property string $name
 * @property integer $ordering
 * @property integer $status
 * @property integer $created
 * @property integer $modified
 */
class PhotoAlbums extends \yii\db\ActiveRecord
{
    const PAGE_ID = 140;
    const ALIAS_PREFIX = '/album';
    const ALBUM_OUR_JOBS = 6;
    const ALBUM_BANNERS = 11;
    const ALBUM_MAIN_BANNERS = 12;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%photo_albums}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'name', 'created'], 'required'],
            [['manager_id', 'ordering', 'status', 'created', 'modified'], 'integer'],
            [['manager_id', 'ordering', 'status', 'created', 'modified'], 'default', 'value' => 0],
            [['name'], 'string', 'max' => 200]
        ];
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function getPhotos() {
        return $this->hasMany(Photos::className(), ['section_id' => 'id'])->orderBy(['ordering' => SORT_ASC]);
    }

    public static function getFilterList() {
        $list = self::find()->orderBy(['ordering' => SORT_ASC, 'id' => SORT_DESC])->all();
        return $list ? ArrayHelper::map($list, 'id', 'name') : [];
    }

    public function afterDelete()
    {
        // удаляем вложенные
        if ($this->photos) {
            foreach ($this->photos AS $photo) {
                // циклом чтобы выполнилось Photos::afterDelete
                $photo->delete();
            }
        }

        parent::afterDelete();
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->modified = time();
        }

        $this->manager_id = Yii::$app->user->id;

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
            'name' => 'Название альбома',
            'ordering' => 'Порядок',
            'status' => 'Статус',
            'created' => 'Создан',
            'modified' => 'Изменен',
        ];
    }
}
