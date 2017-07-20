<?php

namespace app\models;

use app\components\SmtpEmail;
use app\helpers\Normalize;
use app\helpers\Statuses;
use Yii;
use yii\helpers\Url;

/**
 * This is the model class for table "{{%faq}}".
 *
 * @property integer $id
 * @property integer $section_id
 * @property integer $user_id
 * @property string $name
 * @property string $email
 * @property string $question_text
 * @property string $answer_text
 * @property integer $created
 * @property integer $ordering
 * @property integer $status
 */
class Faq extends \yii\db\ActiveRecord
{
    const ALIAS_PREFIX = 'site/answer';
    const PAGE_ID = 181;
    const PAGE_ADD_ID = 192;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%faq}}';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['section_id', 'name', 'email', 'question_text'], 'required'],
            [['answer_text'], 'required', 'when' => function($model){
                return ($model->status == Statuses::STATUS_ACTIVE || $model->send_answer);
            }, 'message' => 'Чтобы отправить/опубликовать {attribute}, необходимо заполнить его'],

            [['bread_text'], 'required', 'when' => function($model){
                return ($model->status == Statuses::STATUS_ACTIVE);
            }, 'message' => 'Чтобы опубликовать вопрос, необходимо заполнить {attribute}'],

            [['email'], 'email'],
            [['section_id', 'manager_id', 'user_id', 'created', 'modified', 'published', 'ordering', 'status', 'views'], 'integer'],
            [['section_id', 'manager_id', 'user_id', 'created', 'modified', 'published', 'ordering', 'status', 'views'], 'default', 'value' => 0],

            [['name', 'email'], 'string', 'max' => 100],
            [['question_text'], 'string', 'max' => 250],
            [['answer_text'], 'string'],
            [['answer_text'], 'default', 'value' => ''],

            ['send_answer', 'boolean'],
        ];
    }

    public function getSection() {
        return $this->hasOne(FaqSections::className(), ['id' => 'section_id']);
    }

    public function getManager() {
        return $this->hasOne(Users::className(), ['id' => 'manager_id']);
    }

    public function beforeValidate()
    {
        if ($this->isNewRecord) {
            if (!Yii::$app->user->isGuest) $this->user_id = Yii::$app->user->id;
            $this->created = time();
        } else {
            $this->modified = time();
        }

        if (Users::isManager()) {
            $this->manager_id = Yii::$app->user->id;
        }

        return parent::beforeValidate();
    }

    public function getBreadcrumbs() {

        $breadcrumbs = [];

        $faq_page = Pages::findOne(self::PAGE_ID);

        $breadcrumbs[] = ['url' => Url::to([Normalize::fixAlias($faq_page->alias)]),
                        'label' => $faq_page->crumb];

        $breadcrumbs[] = ['url' => Url::to(['faq', 'section' => $this->section_id]),
                        'label' => $this->section->name];

        $breadcrumbs[] = ['label' => mb_substr($this->question_text, 0, 100, Yii::$app->charset)];

        return $breadcrumbs;
    }

    public function save($runValidation = true, $attributeNames = null)
    {
        if ($this->isNewRecord) {

        } else {
            $self = self::findOne($this->id);
            // отправляем письмо один раз
            if ($this->send_answer) {
                $smtp = new SmtpEmail();
                $smtp->sendEmailByType(SmtpEmail::TYPE_ANSWER, $this->email, $this->name, [
                    '{question}' => nl2br($this->question_text),
                    '{answer}' => nl2br($this->answer_text),
                ], false);
            } else {
                $this->send_answer = $self->send_answer;
            }
        }

        return parent::save($runValidation, $attributeNames);
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'section_id' => 'Раздел',
            'manager_id' => 'Менеджер',
            'user_id' => 'Автор',
            'name' => 'Имя',
            'email' => 'Email',
            'question_text' => 'Вопрос',
            'answer_text' => 'Ответ',
            'created' => 'Создан',
            'modified' => 'Изменен',
            'published' => 'Опубликован',
            'ordering' => 'Порядок',
            'status' => 'Статус',
            'send_answer' => 'Отвечен',
            'bread_text' => 'Текст хлебной крошки'
        ];
    }
}
