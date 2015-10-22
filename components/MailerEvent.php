<?php
namespace app\components;

use app\models\CustomMailer;
use app\models\User;
use yii\base\Component;
use yii\base\Event;

class MailerEvent extends Event
{
    public $user;
    public $tour;
    public $flight;

    public function userRegistered(){
        CustomMailer::userRegisteredEvent(\Yii::$app->params['adminEmailMain'], null, ['user' => $this->user]);
    }

    public function managerCreateHotTour(){
        if($users = User::findAll(['region_id' => $this->tour->region_manager_id, 'role' => 1, 'approved' => 1, 'email_about_hot_tour' => 1])){
            CustomMailer::sendMultipleMailsAboutManagerHotTourCreate($users, null, ['tour' => $this->tour]);
        }
    }

    public function managerCreateResponseTour(){
        if($users = User::findAll(['region_id' => $this->tour->region_manager_id, 'role' => 1, 'approved' => 1, 'email_about_tour' => 1])) {
            CustomMailer::sendMultipleMailsAboutManagerResponseTourCreate($users, null, ['tour' => $this->tour]);
        }
    }

    public function managerCreateResponseFlight(){
        if($users = User::findAll(['id' => $this->flight->user_id, 'role' => 1, 'approved' => 1, 'email_about_flight' => 1])) {
            CustomMailer::sendMultipleMailsAboutManagerResponseFlightCreate($users, null, ['flight' => $this->flight]);
        }
    }

    public function userCreateTour(){
        if($users = User::findAll(['region_id' => $this->tour->region_owner_id, 'role' => 2, 'approved' => 1, 'email_about_user_tour' => 1])) {
            CustomMailer::sendMultipleMailsToManagerAboutNewUserTour($users, null, ['tour' => $this->tour]);
        }
    }

    public function userCreateFlight(){
        if($users = User::findAll(['region_id' => $this->flight->region_owner_id, 'role' => 2, 'approved' => 1, 'email_about_user_flight' => 1])) {
            CustomMailer::sendMultipleMailsToManagerAboutNewUserFlight($users, null, ['flight' => $this->flight]);
        }
    }
}