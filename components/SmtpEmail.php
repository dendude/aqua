<?php

namespace app\components;

use app\models\EmailTemplates;
use app\models\Settings;
use rmrevin\yii\postman\Component;
use rmrevin\yii\postman\models\LetterModel;
use rmrevin\yii\postman\RawLetter;
use Yii;
use yii\bootstrap\Html;

class SmtpEmail extends \yii\base\Component {

	const TYPE_REGISTER = 1;
    const TYPE_RESTORE = 4;
    const TYPE_NEW_PASSWORD = 9;
    const TYPE_NEW_QUESTION = 10;
    const TYPE_ANSWER_QUESTION = 8;
    const TYPE_NEW_REVIEW = 11;
    const TYPE_REVIEW_NOTIFICATION = 6;

    // отправка письма
	public function sendEmail($email, $name, $subject, $content) {

        // получение конфига почты
        $settings = Settings::lastSettings();

        Yii::$app->postman->smtp_config = [
            'auth' => true,
            'user' => $settings->email_username,
            'password' => $settings->email_password,
            'host' => $settings->email_host,
            'port' => $settings->email_port,
            'default_from' => [$settings->email_username, $settings->email_fromname],
            'secure' => 'tls',
            'debug' => false,
        ];
        Yii::$app->postman->init();

        $letter = new RawLetter();
        $letter->setFrom([$settings->email_username, $settings->email_fromname]);
        $letter->setSubject($subject);
        $letter->setBody($content);
        $letter->addAddress([$email, $name]);

        $result = $letter->send();
        if ($result) {
            // добавлено в очередь и будет отправлено по cron
        } else {
            echo $letter->getLastError();
            die;
        }

        return $result;
	}

	public function sendEmailByType($typeId, $email, $name, $data = []) {

        $template = EmailTemplates::findOne($typeId);
        $settings = Settings::find()->orderBy(['id' => SORT_DESC])->one();

        if ($template) {
            // контент письма
            $content = $template->content;

            // для подстановки имени
            $data['{name}'] = $name;
            $data['{email}'] = $email;
            $data['{sitename}'] = Html::a(Yii::$app->params['sitename'], Yii::$app->request->hostInfo);

            // добавляем подпись письма
            $content .= Html::tag('p', nl2br($settings->email_sign), ['style' => 'margin-top: 25px']);
            // замена переменных
            $content = str_replace(array_keys($data), array_values($data), $content);

            return $this->sendEmail($email, $name, $template->subject, $content);
        }

		return false;
	}
}
