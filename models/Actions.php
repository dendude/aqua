<?php

namespace app\models;

use app\components\simple_html_dom;
use app\helpers\Normalize;
use Yii;
use yii\helpers\Url;

class Actions extends \yii\db\ActiveRecord
{
    const ALIAS_PREFIX = '/action/';
    const PAGE_ID = 13;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%actions}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['manager_id', 'menu_title', 'title', 'alias', 'about', 'content', 'section_id'], 'required'],

            [['alias'], 'unique', 'message' => 'Такая ссылка уже занята'],
            
            [['manager_id', 'created', 'modified', 'views', 'ordering', 'status', 'section_id'], 'integer'],
            [['manager_id', 'created', 'modified', 'views', 'ordering', 'status', 'section_id'], 'default', 'value' => 0],
            
            [['about', 'content'], 'string'],
            [['alias'], 'string', 'max' => 200],
            [['menu_title', 'title'], 'string', 'max' => 150],
            [['meta_t', 'meta_k', 'meta_d'], 'string', 'max' => 250],

            [['menu_title', 'title', 'meta_t', 'meta_k', 'meta_d'], 'default', 'value' => ''],
        ];
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function getSection() {
        return $this->hasOne(ActionsSections::className(), ['id' => 'section_id']);
    }

    public function getBreadcrumbs() {

        $breadcrumbs = [];

        $page = Pages::findOne(self::PAGE_ID);

        $breadcrumbs[] = ['url' => Url::to([Normalize::fixAlias($page->alias)]),
                        'label' => $page->crumb];

        $breadcrumbs[] = ['url' => Url::to([$page->alias, 'section' => $this->section->id]),
                        'label' => $this->section->name];

        $breadcrumbs[] = ['label' => $this->title];

        return $breadcrumbs;
    }

    public function getFixLinksContent() {

        if (!empty($this->content)) {
            // преобразование ссылок в контенте, вдруг сохранены неправильно
            $dom = new simple_html_dom();
            $dom->load($this->content);
            foreach ($dom->find('a') AS $a) {
                // убираем суффикс
                $a->href = trim(str_replace(Yii::$app->urlManager->suffix, '', $a->href), '/');
                // получаем полную ссылку
                $a->href = Url::to([Normalize::fixAlias($a->href)]);
            }

            $this->content = $dom->outertext;
        }

        return $this->content;
    }

    public function getFirstImage() {

        $image = '';

        if (!empty($this->content)) {
            // преобразование ссылок в контенте, вдруг сохранены неправильно
            $dom = new simple_html_dom();
            $dom->load($this->content);
            if ($dom->find('img')) {
                $image = $dom->find('img',0)->src;
                if (strpos($image, 'http') === false) {
                    $image = Yii::$app->request->hostInfo . $image;
                }
            }
        }

        return $image;
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


    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'manager_id' => 'Менеджер',
            'section_id' => 'Раздел',
            'menu_title' => 'Название в виджете',
            'title' => 'Заголовок (Н1)',
            'alias' => 'Alias (URL)',
            'about' => 'Краткое описание',
            'content' => 'Содержание',
            'meta_t' => 'Meta Title',
            'meta_k' => 'Meta Keywords',
            'meta_d' => 'Meta Description',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'views' => 'Просмотров',
            'ordering' => 'Порядок',
            'status' => 'Статус',
        ];
    }
}
