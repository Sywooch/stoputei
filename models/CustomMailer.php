<?php
namespace app\models;

class CustomMailer
{
    public static function sendSingleMail($view, $subject, $to, $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        \Yii::$app->mailer->compose($view, $params)
        ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}