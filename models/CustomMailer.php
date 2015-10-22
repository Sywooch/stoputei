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

    public static function userRegisteredEvent($to, $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        \Yii::$app->mailer->compose('user-registered', $params)
            ->setFrom($from)
            ->setTo($to)
            ->setSubject(\Yii::t('app', 'New user registered'))
            ->send();
    }

    public static function sendMultipleMailsAboutManagerHotTourCreate($users = array(), $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        $messages = [];
        foreach ($users as $user) {
            $messages[] = \Yii::$app->mailer->compose('create-hot-tour-manager', $params)
                ->setFrom($from)
                ->setTo($user->email)
                ->setSubject(\Yii::t('app', 'New hot tour was created'));
        }
        \Yii::$app->mailer->sendMultiple($messages);
    }

    public static function sendMultipleMailsAboutManagerResponseTourCreate($users = array(), $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        $messages = [];
        foreach ($users as $user) {
            $messages[] = \Yii::$app->mailer->compose('create-response-tour-manager', $params)
                ->setFrom($from)
                ->setTo($user->email)
                ->setSubject(\Yii::t('app', 'New tour response was created'));
        }
        \Yii::$app->mailer->sendMultiple($messages);
    }

    public static function sendMultipleMailsAboutManagerResponseFlightCreate($users = array(), $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        $messages = [];
        foreach ($users as $user) {
            $messages[] = \Yii::$app->mailer->compose('create-response-flight-manager', $params)
                ->setFrom($from)
                ->setTo($user->email)
                ->setSubject(\Yii::t('app', 'New flight response was created'));
        }
        \Yii::$app->mailer->sendMultiple($messages);
    }

    public static function sendMultipleMailsToManagerAboutNewUserTour($users = array(), $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        $messages = [];
        foreach ($users as $user) {
            $messages[] = \Yii::$app->mailer->compose('new-user-tour', $params)
                ->setFrom($from)
                ->setTo($user->email)
                ->setSubject(\Yii::t('app', 'New user tour was created'));
        }
        \Yii::$app->mailer->sendMultiple($messages);
    }

    public static function sendMultipleMailsToManagerAboutNewUserFlight($users = array(), $from = null, $params = null){
        if(is_null($from)){
            $from = \Yii::$app->params['adminEmail'];
        }
        $messages = [];
        foreach ($users as $user) {
            $messages[] = \Yii::$app->mailer->compose('new-user-flight', $params)
                ->setFrom($from)
                ->setTo($user->email)
                ->setSubject(\Yii::t('app', 'New user flight was created'));
        }
        \Yii::$app->mailer->sendMultiple($messages);
    }
}