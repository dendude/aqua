<?php

namespace app\commands;
use rmrevin\yii\postman\models\LetterModel;
use yii\console\Controller;

class EmailsController extends Controller
{
    public function actionSend()
    {
        // рассылка писем
        LetterModel::cron(10);
    }
}
