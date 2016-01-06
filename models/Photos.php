<?php

namespace app\models;

use app\models\forms\UploadForm;
use Yii;

/**
 * This is the model class for table "{{%photos}}".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property integer $section_id
 * @property string $title
 * @property string $about
 * @property string $img_small
 * @property string $img_big
 * @property integer $ordering
 * @property integer $created
 * @property integer $modified
 * @property integer $status
 */
class Photos extends \yii\db\ActiveRecord
{
    public $img_small_arr = [];
    public $img_big_arr = [];
    public $page_arr = [];
    public $title_arr = [];
    public $about_arr = [];
    public $ordering_arr = [];

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%photos}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'section_id', 'img_small', 'img_big'], 'required'],

            [['manager_id', 'section_id', 'ordering', 'created', 'modified', 'status'], 'integer'],
            [['manager_id', 'section_id', 'ordering', 'created', 'modified'], 'default', 'value' => 0],
            [['status'], 'default', 'value' => 1], // публикуем все

            [['title', 'img_small', 'img_big'], 'string', 'max' => 100],
            [['about'], 'string', 'max' => 250],

            [['title', 'img_small', 'img_big', 'about'], 'default', 'value' => ''],

            ['page_id', 'integer'],
            ['page_id', 'default', 'value' => 0],

            [['page_arr', 'title_arr', 'img_small_arr', 'img_big_arr', 'about_arr', 'ordering_arr'], 'safe'],
        ];
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function getSection() {
        return $this->hasOne(PhotoAlbums::className(), ['id' => 'section_id']);
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

    public function afterDelete()
    {
        // чистка файлов
        $path_dir = Yii::$app->basePath . '/' . UploadForm::UPLOAD_DIR . '/' . UploadForm::TYPE_GALLERY . '/';

        $path_small = $path_dir . $this->img_small;
        $path_big = $path_dir . $this->img_big;

        if (file_exists($path_small)) unlink($path_small);
        if (file_exists($path_big)) unlink($path_big);

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
            'section_id' => 'Альбом',
            'page_id' => 'Ссылка на страницу',
            'title' => 'Заголовок',
            'about' => 'Описание',
            'img_small' => 'Img Small',
            'img_big' => 'Img Big',
            'ordering' => 'Порядок',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'status' => 'Статус',
        ];
    }
}
