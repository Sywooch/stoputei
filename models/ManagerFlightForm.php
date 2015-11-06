<?php

namespace app\models;

use Yii;
use yii\base\Model;


class ManagerFlightForm extends Model
{
    public $destination;
    public $resort;
    public $way_ticket;
    public $depart_city_to;
    public $depart_country_to;
    public $depart_city_from;
    public $date_city_to;
    public $date_city_from;
    public $voyage_is_direct_to;
    public $voyage_direct_to_id;
    public $voyage_direct_country_to;
    public $voyage_direct_from_id;
    public $voyage_direct_country_from;
    public $voyage_is_direct_from;
    public $date_docking_to_hours;
    public $date_docking_from_hours;
    public $date_docking_to_minutes;
    public $date_docking_from_minutes;
    public $tickets_exist;
    public $adult_count_senior_24;
    public $adult_count_under_24;
    public $children_under_12_amount;
    public $children_under_2_amount;
    public $flight_class;
    public $regular_flight;
    public $user_id;
    public $from_flight_id;
    public $flight_cost;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'depart_city_to', 'date_city_to', 'flight_class', 'regular_flight', 'flight_cost', 'tickets_exist'], 'required'],
            [['regular_flight', 'adult_count_under_24', 'children_under_12_amount', 'children_under_2_amount', 'voyage_is_direct_from', 'voyage_is_direct_to', 'voyage_direct_to_id', 'voyage_direct_from_id', 'tickets_exist'], 'default', 'value' => 0],
            [['way_ticket', 'adult_count_senior_24'], 'default', 'value' => 1],
            [['depart_city_from', 'date_city_from'], 'required', 'message' => Yii::t('app','{attribute} must be checked.'), 'when' => function ($model) {
                return $model->way_ticket == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"ManagerFlightForm[way_ticket]\"]').val() == 2;
            }"],
            ['date_city_to', 'compare', 'compareAttribute' => 'date_city_from', 'operator'=>'<', 'message' => Yii::t('app','{attribute} must be less than {attribute}.'), 'when' => function ($model) {
                return $model->way_ticket == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"ManagerFlightForm[way_ticket]\"]').val() == 2;
            }"],
            [['date_docking_to_hours', 'date_docking_to_minutes', 'date_docking_from_hours', 'date_docking_from_minutes', 'user_id', 'from_flight_id', 'date_city_to'], 'default', 'value' => null],
            [['tickets_exist'], 'default', 'value' => 1]
        ];
    }


    public function attributeLabels()
    {
        return [
            'destination' => Yii::t('app', 'Destination'),
            'resort' => Yii::t('app', 'Resort/City'),
            'way_ticket' => Yii::t('app', 'Way ticket'),
            'depart_city_to' => Yii::t('app', 'Depart city to'),
            'depart_country_to' => Yii::t('app', 'Depart country'),
            'depart_city_from' => Yii::t('app', 'Depart city from'),
            'date_city_to' => Yii::t('app', 'Flight start time'),
            'voyage_is_direct_to' => Yii::t('app', 'Voyage'),
            'voyage_is_direct_from' => Yii::t('app', 'Voyage'),
            'date_city_from' => Yii::t('app', 'Flight end time'),
            'voyage_direct_to_id' => Yii::t('app', 'Voyage through'),
            'voyage_direct_country_to' => Yii::t('app', 'Depart country through'),
            'voyage_direct_from_id' => Yii::t('app', 'Voyage through'),
            'voyage_direct_country_from' => Yii::t('app', 'Depart country through'),
            'date_docking_to_hours' => Yii::t('app', 'Date docking (hours)'),
            'date_docking_from_hours' => Yii::t('app', 'Date docking (hours)'),
            'date_docking_to_minutes' => Yii::t('app', 'Date docking (minutes)'),
            'date_docking_from_minutes' => Yii::t('app', 'Date docking (minutes)'),
            'adult_count_senior_24' => Yii::t('app', 'Amount of adult senior 24 years old'),
            'adult_count_under_24' => Yii::t('app', 'Amount of adult under 24 years old'),
            'children_under_12_amount' => Yii::t('app', 'Amount of children (under 12 years old)'),
            'children_under_2_amount' => Yii::t('app', 'Amount of children (under 2 years old)'),
            'flight_class' => Yii::t('app', 'Flight class'),
            'regular_flight' => Yii::t('app', 'Flight type'),
            'tickets_exist' => Yii::t('app', 'Tickets exist'),
            'flight_cost' => Yii::t('app', 'Flight cost')
        ];
    }
}
