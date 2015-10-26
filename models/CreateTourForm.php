<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class CreateTourForm extends Model
{
    public $destination;
    public $resort;
    public $hotel;
    public $hotel_id;
    public $stars;
    public $apartment;
    public $nutrition;
    public $night_count;
    public $location;
    public $room_type;
    public $hotel_type;
    public $beach_line;
    public $room_view;
    public $adult_amount;
    public $children_under_12_amount;
    public $children_under_2_amount;
    public $room_count;
    public $flight_included;
    public $depart_city_there;
    public $depart_country_there;
    public $from_date;
    public $voyage_there;
    public $voyage_through_city_there;
    public $depart_city_from_there;
    public $depart_country_from_there;
    public $to_date;
    public $voyage_from_there;
    public $voyage_through_city_from_there;
    public $add_payment;
    public $visa;
    public $oil_tax;
    public $tickets_exist;
    public $medicine_insurance;
    public $charge_manager;
    public $tour_cost;
    public $user_id;
    public $from_tour_id;
    public $is_hot_tour;
    public $hotel_star;
    public $letter_filter;
    public $deadline;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'adult_amount', 'room_count', 'nutrition', 'location', 'room_type', 'room_view', 'tour_cost'], 'required'],
            [['stars', 'apartment'], 'default', 'value' => []],
            [['hotel_id', 'oil_tax', 'visa', 'voyage_through_city_there', 'voyage_through_city_from_there', 'deadline'], 'default', 'value' => null],
            [['adult_amount', 'children_under_12_amount', 'children_under_2_amount', 'room_count', 'night_count', 'user_id', 'from_tour_id', 'room_view', 'beach_line', 'hotel_type', 'room_type', 'location', 'nutrition', 'hotel_star', 'tour_cost'], 'integer'],
            ['stars', 'each', 'rule' => ['in', 'range' => [400, 401, 402, 403, 404]]],
            ['letter_filter', 'each', 'rule' => ['in', 'range' => ['a', 'b', 'c', 'd']]],
            [['flight_included' ], 'default', 'value' => 1],
            [['add_payment', 'tickets_exist', 'charge_manager', 'medicine_insurance', 'voyage_from_there', 'voyage_there', 'room_view', 'beach_line', 'hotel_type', 'room_type', 'location', 'nutrition', 'hotel_star'], 'default', 'value' => 0],
            ['from_date', 'required', 'message' => Yii::t('app','Field "From date" must be date type.'), 'when' => function ($model) {
                return $model->flight_included == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"CreateTourForm[flight_included]\"]').val() == 1;
            }"],
            ['to_date', 'required', 'message' => Yii::t('app','Field "To date" must be date type.'), 'when' => function ($model) {
                return $model->flight_included == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"CreateTourForm[flight_included]\"]').val() == 1;
            }"],
            ['from_date', 'compare', 'compareAttribute' => 'to_date', 'operator'=>'<', 'message' => Yii::t('app','Field "To date" must be bigger than "From date".'), 'when' => function ($model) {
                return $model->flight_included == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"CreateTourForm[flight_included]\"]').val() == 1;
            }"],
            [['depart_city_from_there', 'depart_city_there'], 'required', 'message' => Yii::t('app','Field "To date" must be bigger than "From date".'), 'when' => function ($model) {
                return $model->flight_included == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"CreateTourForm[flight_included]\"]').val() == 1;
            }"],
            [['hotel'], 'required', 'when' => function ($model) {
                return $model->hotel_id == null;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"CreateTourForm[hotel_id]\"]').val() == '';
            }"],
        ];
    }

    public function attributeLabels()
    {
        return [
            'destination' => Yii::t('app', 'Destination'),
            'resort' => Yii::t('app', 'Resort'),
            'hotel' => Yii::t('app', 'Hotel'),
            'stars' => Yii::t('app', 'Category'),
            'nutrition' => Yii::t('app', 'Nutrition'),
            'night_count' => Yii::t('app', 'Night count'),
            'location' => Yii::t('app', 'Apartment'),
            'room_type' => Yii::t('app', 'Room type'),
            'hotel_type' => Yii::t('app', 'Hotel type'),
            'beach_line' => Yii::t('app', 'Beach line'),
            'room_view' => Yii::t('app', 'Room view'),
            'adult_amount' => Yii::t('app', 'Amount of adult'),
            'children_under_12_amount' => Yii::t('app', 'Amount of children (under 12 years old)'),
            'children_under_2_amount' => Yii::t('app', 'Amount of children (under 2 years old)'),
            'room_count' => Yii::t('app', 'Amount of room'),
            'flight_included' => Yii::t('app', 'Flight included'),
            'depart_city_there' => Yii::t('app', 'Depart city there'),
            'depart_country_there' => Yii::t('app', 'Depart country'),
            'from_date' => Yii::t('app', 'Date start'),
            'voyage_there' => Yii::t('app', 'Voyage'),
            'voyage_through_city_there' => Yii::t('app', 'Voyage through'),
            'depart_city_from_there' => Yii::t('app', 'Depart city from there'),
            'depart_country_from_there' => Yii::t('app', 'Depart country'),
            'to_date' => Yii::t('app', 'Date end from'),
            'voyage_from_there' => Yii::t('app', 'Voyage'),
            'voyage_through_city_from_there' => Yii::t('app', 'Voyage through'),
            'add_payment' => Yii::t('app', 'Payment is absent'),
            'visa' => Yii::t('app', 'Visa'),
            'oil_tax' => Yii::t('app', 'Oil tax'),
            'tickets_exist' => Yii::t('app', 'Tickets exist'),
            'medicine_insurance' => Yii::t('app', 'Medicine insurance'),
            'charge_manager' => Yii::t('app', 'Manager\'s charge'),
            'tour_cost' => Yii::t('app', 'Tour cost'),
            'letter_filter' => Yii::t('app', 'Letter filter'),
            'deadline' => Yii::t('app', 'Tour\'s deadline'),
        ];
    }
}
