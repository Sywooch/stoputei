<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class GetTourForm extends Model
{
    public $destination;
    public $resort;
    public $hotel;
    public $hotel_id;
    public $stars;
    public $nutrition;
    public $beach_line;
    public $hotel_type;
    public $room_type;
    public $depart_country;
    public $depart_city;
    public $night_min;
    public $night_max;
    public $adult_amount;
    public $children_under_12_amount;
    public $children_under_2_amount;
    public $room_count;
    public $flight_included;
    public $from_date;
    public $budget;
    public $add_info;
    public $letter_filter;
    public $exactly_date;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'nutrition', 'night_min', 'night_max', 'adult_amount', 'children_under_12_amount', 'children_under_2_amount', 'room_count'], 'required'],
            ['add_info', 'string', 'max' => 255],
            ['flight_included', 'boolean'],
            ['hotel_id', 'safe'],
            [['hotel_id', 'beach_line'], 'default', 'value' => null],
            ['stars', 'each', 'rule' => ['in', 'range' => [400, 401, 402, 403, 404]]],
            ['nutrition', 'each', 'rule' => ['in', 'range' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9]]],
            ['beach_line', 'each', 'rule' => ['in', 'range' => [0, 1, 2, 3]]],
            ['room_type', 'each', 'rule' => ['in', 'range' => [0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11]]],
            ['letter_filter', 'each', 'rule' => ['in', 'range' => ['a', 'b', 'c', 'd']]],
            [['budget', 'night_max'], 'integer'],
            [['budget', 'hotel_type', 'exactly_date'], 'default', 'value' => 0],
            ['stars', 'required',  'message' => Yii::t('app','{attribute} must be checked.'), 'when' => function ($model) {
                return $model->hotel_id == '';
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"GetTourForm[hotel_id]\"]').val() == '';
            }"],
            /*[['from_date', 'depart_city'], 'required',  'message' => Yii::t('app','{attribute} can not be blank.'), 'when' => function ($model) {
                return $model->flight_included == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"GetTourForm[flight_included]\"]').val() == 1;
            }"],*/
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
            'beach_line' => Yii::t('app', 'Beach line'),
            'hotel_type' => Yii::t('app', 'Hotel type'),
            'room_type' => Yii::t('app', 'Room type'),
            'depart_city' => Yii::t('app', 'Depart city'),
            'depart_country' => Yii::t('app', 'Depart country'),
            'night_min' => Yii::t('app', 'Night count min'),
            'night_max' => Yii::t('app', 'Night count max'),
            'adult_amount' => Yii::t('app', 'Amount of adult'),
            'children_under_12_amount' => Yii::t('app', 'Amount of children (under 12 years old)'),
            'children_under_2_amount' => Yii::t('app', 'Amount of children (under 2 years old)'),
            'room_count' => Yii::t('app', 'Amount of room'),
            'flight_included' => Yii::t('app', 'Flight included'),
            'from_date' => Yii::t('app', 'Flight to since'),
            'budget' => Yii::t('app', 'Budget'),
            'add_info' => Yii::t('app', 'Add information'),
            'letter_filter' => Yii::t('app', 'Letter filter'),
            'exactly_date' => Yii::t('app', ''),
        ];
    }
}
