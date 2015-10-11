<?php

namespace app\models\forms;

use app\components\SmtpEmail;
use app\models\Reviews;
use Yii;
use yii\base\Model;

class ReviewForm extends Model
{
    public $name;
    public $email;
    public $comment;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['name', 'email', 'comment'], 'trim'],
            [['name', 'email', 'comment'], 'required'],

            ['email', 'email'],

            [['comment'], 'string', 'min' => 10, 'tooShort' => 'Введите не менее {min} символов'],
        ];
    }

    public function send()
    {
        $review = new Reviews();
        $review->attributes = $this->attributes;

        if ($review->save()) {

            $smtp = new SmtpEmail();
            if ($smtp->sendEmailByType(SmtpEmail::TYPE_NEW_REVIEW, $review->email, $review->name, ['{review_text}' => $this->comment])) {
                return true;
            } else {
                $review->delete();
            }
        }

        return false;
    }

    public function attributeLabels() {
        return [
            'name' => 'Ваше имя',
            'email' => 'Ваш Email',
            'comment' => 'Ваш отзыв',
        ];
    }
}
