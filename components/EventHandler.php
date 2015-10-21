<?php
namespace app\components;

use yii\base\Component;
use yii\base\Event;

class EventHandler extends Component
{
    const EVENT_USER_REGISTERED = 'user_registered';
    const EVENT_NEW_USER_TOUR = 'tour_request';
    const EVENT_NEW_USER_FLIGHT = 'flight_request';
    const EVENT_MANAGER_TOUR_RESPONSE = 'tour_response';
    const EVENT_MANAGER_FLIGHT_RESPONSE = 'flight_response';
    const EVENT_MANAGER_HOT_TOUR = 'create_hot_tour';
    const EVENT_SINGLE_REGION_PAY = 'single_region_pay';
    const EVENT_MULTIPLE_REGION_PAY = 'multiple_region_pay';

    public function userRegistered(){
        $this->trigger(self::EVENT_USER_REGISTERED);
    }

    public function newUserTour(){
        $this->trigger(self::EVENT_NEW_USER_TOUR);
    }

    public function newUserFlight(){
        $this->trigger(self::EVENT_NEW_USER_FLIGHT);
    }

    public function managerTourResponse(){
        $this->trigger(self::EVENT_MANAGER_TOUR_RESPONSE);
    }

    public function managerFlightResponse(){
        $this->trigger(self::EVENT_MANAGER_FLIGHT_RESPONSE);
    }

    public function managerHotTour(){
        $this->trigger(self::EVENT_MANAGER_HOT_TOUR);
    }

    public function singleRegionPay(){
        $this->trigger(self::EVENT_SINGLE_REGION_PAY);
    }

    public function multipleRegionPay(){
        $this->trigger(self::EVENT_MULTIPLE_REGION_PAY);
    }
}