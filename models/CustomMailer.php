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

    public static function sendContactForm($view = 'contact', $subject = null, $to = null, $from = null, $params = null){
        if(is_null($subject)){
            $subject = \Yii::t('app', 'Mail from contact form');
        }
        if(is_null($to)){
            $to = \Yii::$app->params['adminEmailMain'];
        }
        \Yii::$app->mailer->compose($view, $params)
            ->setFrom($from)
            ->setTo($to)
            ->setSubject($subject)
            ->send();
    }

    public static function resetPassword($to, $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        \Yii::$app->mailer->compose('reset-password', $params)
            ->setFrom($from)
            ->setTo($to)
            ->setSubject(\Yii::t('app', 'Reset password'))
            ->send();
    }
}