<?php
namespace app\components;

use app\models\Country;
use app\models\FlightResponse;
use app\models\ManagerStatisticsFlightForm;
use app\models\UserFlight;
use yii\base\Widget;

class ManagerFlightStatisticsWidget extends Widget
{
    public $ManagerFlightStatisticsForm;
    public $destinationDropdown;
    public $periodDropdown;
    public $all_requests;
    public $all_responses;
    public $all_hot_tours;

    public function init()
    {
        parent::init();
        $country = new Country();
        $this->ManagerFlightStatisticsForm = new ManagerStatisticsFlightForm();
        $this->destinationDropdown = $country->destinationDropdown();
        $this->periodDropdown = [0 => \Yii::t('app', 'All period'), 86400 => \Yii::t('app', 'Per day'), 604800 => \Yii::t('app', 'Per week'), 2592000 => \Yii::t('app', 'Per month')];

        $this->all_requests = UserFlight::find()->where([
            'region_owner_id' => \Yii::$app->user->identity->region_id
        ])->count();

        $this->all_responses = FlightResponse::find()->where([
            'manager_id' => \Yii::$app->user->identity->getId(),
        ])->count();

    }

    public function run()
    {
        return $this->render('manager-flight-statistics', [
            'ManagerFlightStatisticsForm' => $this->ManagerFlightStatisticsForm,
            'destinationDropdown' => $this->destinationDropdown,
            'periodDropdown' => $this->periodDropdown,
            'all_requests' => $this->all_requests,
            'all_responses' => $this->all_responses
        ]);
    }
}