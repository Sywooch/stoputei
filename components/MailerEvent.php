<?php
namespace app\components;

use app\models\CustomMailer;
use yii\base\Component;
use yii\base\Event;

class MailerEvent extends Event
{
    public $user;

    public function userLogin(){
        CustomMailer::userRegisteredEvent(\Yii::$app->params['adminEmailMain'], null, ['user' => $this->user]);
    }
}