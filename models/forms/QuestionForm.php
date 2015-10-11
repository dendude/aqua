<?php

namespace app\models\forms;

use app\components\SmtpEmail;
use app\models\Faq;
use app\models\Users;
use Yii;
use yii\base\ErrorException;
use yii\base\Exception;
use yii\base\Model;
use yii\helpers\Url;

class QuestionForm extends Model
{
    public $name;
    public $email;
    public $section_id;
    public $question_text;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'question_text'], 'trim'],
            [['name', 'email', 'section_id', 'question_text'], 'required'],

            ['email', 'email'],

            [['question_text'], 'string', 'min' => 10, 'tooShort' => 'Введите не менее {min} символов'],
        ];
    }

    public function send()
    {
        $question = new Faq();
        $question->attributes = $this->attributes;

        if ($question->save()) {

            $smtp = new SmtpEmail();
            if ($smtp->sendEmailByType(SmtpEmail::TYPE_NEW_QUESTION, $question->email, $question->name, ['{question_text}' => $this->question_text])) {
                return true;
            } else {
                $question->delete();
            }
        }

        return false;
    }

    public function attributeLabels() {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш Email',
            'section_id' => 'Раздел вопроса',
            'question_text' => 'Текст вопроса',
        ];
    }
}
