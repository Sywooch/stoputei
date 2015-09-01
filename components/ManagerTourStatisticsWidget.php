<?php
namespace app\components;

use app\models\Country;
use yii\base\Widget;
use app\models\ManagerStatisticsTourForm;
use app\models\UserTour;
use app\models\TourResponse;

class ManagerTourStatisticsWidget extends Widget
{
    public $ManagerTourStatisticsForm;
    public $destinationDropdown;
    public $periodDropdown;
    public $all_requests;
    public $all_responses;
    public $all_hot_tours;

    public function init()
    {
        parent::init();
        $country = new Country();
        $this->ManagerTourStatisticsForm = new ManagerStatisticsTourForm();
        $this->destinationDropdown = $country->destinationDropdown();
        $this->periodDropdown = [0 => \Yii::t('app', 'All period'), 86400 => \Yii::t('app', 'Per day'), 604800 => \Yii::t('app', 'Per week'), 2592000 => \Yii::t('app', 'Per month')];

        $this->all_requests = UserTour::find()->where([
            'region_owner_id' => \Yii::$app->user->identity->region_id
        ])->count();

        $this->all_responses = TourResponse::find()->where([
            'manager_id' => \Yii::$app->user->identity->getId(),
            'is_hot_tour' => 0
        ])->count();

        $this->all_hot_tours = TourResponse::find()->where([
            'manager_id' => \Yii::$app->user->identity->getId(),
            'is_hot_tour' => 1
        ])->count();

    }

    public function run()
    {
        return $this->render('manager-tour-statistics', [
            'ManagerTourStatisticsForm' => $this->ManagerTourStatisticsForm,
            'destinationDropdown' => $this->destinationDropdown,
            'periodDropdown' => $this->periodDropdown,
            'all_requests' => $this->all_requests,
            'all_responses' => $this->all_responses,
            'all_hot_tours' => $this->all_hot_tours
        ]);
    }
}