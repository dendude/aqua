<?php

namespace app\commands;
use app\models\Settings;
use rmrevin\yii\postman\models\LetterModel;
use yii\console\Controller;

class EmailsController extends Controller
{
    public function actionSend()
    {
        $settings = Settings::lastSettings();
        \Yii::$app->postman->smtp_config = [
            'auth' => true,
            'user' => $settings->email_username,
            'password' => $settings->email_password,
            'host' => $settings->email_host,
            'port' => $settings->email_port,
            'default_from' => [$settings->email_username, $settings->email_fromname],
            'secure' => 'tls',
            'debug' => false,
        ];
        \Yii::$app->postman->init();

        // рассылка писем
        LetterModel::cron(10);
    }
}
