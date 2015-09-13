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

    public static function sendContactForm($view = 'contact', $subject, $to = null, $from = null, $params = null){
        if(is_null($to)){
            $to = \Yii::$app->params['adminEmailContact'];
        }
        \Yii::$app->mailer->compose($view, $params)
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }
}