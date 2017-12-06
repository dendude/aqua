<?php

namespace app\models;

use app\models\forms\UploadForm;
use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%photos}}".
 *
 * @property integer $id
 * @property integer $manager_id
 * @property string $preview_url
 * @property string $video_url
 * @property string $title
 * @property string $about
 * @property integer $ordering
 * @property integer $created
 * @property integer $modified
 * @property integer $status
 */
class Videos extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%videos}}';
    }

    public function rules()
    {
        return [
            [['manager_id', 'preview_url', 'video_url', 'title', 'created'], 'required'],
            [['manager_id', 'preview_url', 'video_url', 'title', 'created'], 'trim'],

            [['manager_id', 'ordering', 'created', 'modified', 'status'], 'integer'],
            [['manager_id', 'ordering', 'created', 'modified'], 'default', 'value' => 0],

            [['title', 'preview_url', 'video_url'], 'string', 'max' => 500],
            [['about'], 'string', 'max' => 1000],
        ];
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function beforeValidate()
    {
        if ($this->video_url) {
            // https://youtu.be/mpMBiEUwKLk или https://www.youtube.com/watch?v=mpMBiEUwKLk
            
            if (preg_match('/^https\:\/\/youtu\.be\/(\w+)$/i', $this->video_url, $matches)) {
                $this->preview_url = "https://img.youtube.com/vi/{$matches[1]}/0.jpg";
            } elseif (preg_match('/^https\:\/\/www\.youtube\.com\/watch\?v\=(\w+)$/i', $this->video_url, $matches)) {
                $this->preview_url = "https://img.youtube.com/vi/{$matches[1]}/0.jpg";
            } else {
                $this->addError('video_url', 'Неверный формат ссылки на видеозапись YouTube');
            }
        }
        
        if ($this->isNewRecord) {
            $this->created = time();
        } else {
            $this->modified = time();
        }

        $this->manager_id = Yii::$app->user->id;

        return parent::beforeValidate();
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Менеджер',
            'title' => 'Название',
            'about' => 'Краткое описание',
            'video_url' => 'Ссылка на видео',
            'preview_url' => 'Обложка',
            'ordering' => 'Порядок',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'status' => 'Статус',
        ];
    }
    
    public static function find() {
        return new VideosQuery(get_called_class());
    }
}