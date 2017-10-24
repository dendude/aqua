<?php

namespace app\components;

use app\models\EmailTemplates;
use app\models\Settings;
use rmrevin\yii\postman\Component;
use rmrevin\yii\postman\models\LetterModel;
use rmrevin\yii\postman\RawLetter;
use Yii;
use yii\bootstrap\Html;
use yii\swiftmailer\Mailer;

class SmtpEmail extends Mailer {

    const TYPE_FREE_TRAVEL = 12;
    const TYPE_CALCULATE = 13;
    const TYPE_CALLBACK = 20;

    const TYPE_CALCULATE_ANSWER = 19;

    const TYPE_QUESTION = 14;
    const TYPE_ANSWER = 15;

    const TYPE_ORDER = 16;

    const TYPE_REVIEW_NEW = 21;
    const TYPE_REVIEW_PUBLISHED = 22;
    
    protected $template;
    
    public function __construct(array $config = []) {
        parent::__construct($config);
        
        // получение конфига почты
        $settings = Settings::lastSettings();
        
        $this->setTransport([
            'class' => 'Swift_SmtpTransport',
            'host' => $settings->email_host,
            'username' => $settings->email_username,
            'password' => $settings->email_password,
            'port' => $settings->email_port,
            'encryption' => false,
        ]);
    }
    
    public function setTemplate($template) {
        $this->template = $template;
    }

        
    // отправка письма
    public function sendEmail($email, $name, $subject, $content, $send_to_managers = false) {
        // получение конфига почты
        $settings = Settings::lastSettings();
        
        // отправка заявителю
        $result = $this->compose(null)
                        ->setHtmlBody($content)
                        ->setFrom([$settings->email_username => $settings->email_fromname])
                        ->setTo([$email => $name])
                        ->setSubject($subject)
                        ->send();
        
        if ($send_to_managers === true && !empty($settings->recievers)) {
            // Дублируем письмо на админские ящики
            $recipients = explode(PHP_EOL, $settings->recievers);
            
            foreach ($recipients AS $email_item) {
                
                usleep(500000);
                $email = trim($email_item);
                
                try {
                    $this->compose(null)
                        ->setHtmlBody($content)
                        ->setFrom([$settings->email_username => $settings->email_fromname])
                        ->setTo([$email => 'Администратор'])
                        ->setSubject($subject)
                        ->send();
                } catch (\Exception $e) {}
            }
        }
        
        return $result;
	}

	public function sendEmailByType($typeId, $email, $name, $data = [], $send_to_managers = true) {

        $template = EmailTemplates::findOne($typeId);
        $settings = Settings::find()->orderBy(['id' => SORT_DESC])->one();

        if ($template) {
            // контент письма
            $content = $template->content;

            // для подстановки имени
            if (empty($data['{name}'])) $data['{name}'] = $name;
            if (empty($data['{email}'])) $data['{email}'] = $email;
            $data['{sitename}'] = Html::a(Yii::$app->request->hostInfo, Yii::$app->request->hostInfo);

            // добавляем подпись письма
            $content .= Html::tag('p', nl2br($settings->email_sign), ['style' => 'margin-top: 25px']);
            // замена переменных
            $content = str_replace(array_keys($data), array_values($data), $content);

            return $this->sendEmail($email, $name, $template->subject, $content, $send_to_managers);
        }

		return false;
	}
}
