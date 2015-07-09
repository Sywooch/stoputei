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
    public $depart_city;
    public $night_min;
    public $night_max;
    public $adult_amount;
    public $children_under_12_amount;
    public $children_under_2_amount;
    public $room_count;
    public $flight_included;
    public $from_date;
    public $to_date;
    public $budget;
    public $add_info;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'night_min', 'night_max', 'adult_amount', 'children_under_12_amount', 'children_under_2_amount', 'room_count', 'depart_city', 'from_date', 'to_date'], 'required'],
            ['add_info', 'string', 'max' => 255],
            ['flight_included', 'boolean'],
            ['hotel_id', 'safe'],
            ['hotel_id', 'default', 'value' => null],
            ['stars', 'each', 'rule' => ['in', 'range' => [400, 401, 402, 403, 404]]],
            ['nutrition', 'each', 'rule' => ['in', 'range' => [0, 1, 2, 3, 4, 5, 6]]],
            ['room_type', 'each', 'rule' => ['in', 'range' => [0, 1, 2, 3, 4, 5, 6, 7]]],
            ['hotel_type', 'each', 'rule' => ['in', 'range' => [0, 1, 2, 3, 4]]],
            ['beach_line', 'each', 'rule' => ['in', 'range' => [0, 1, 2, 3]]],
            ['budget', 'integer'],
            [['budget'], 'default', 'value' => 1000],
            ['from_date', 'compare', 'compareAttribute' => 'to_date', 'operator'=>'<'],
            ['night_min', 'compare', 'compareAttribute' => 'night_max', 'operator'=>'<'],
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
            'night_min' => Yii::t('app', 'From'),
            'night_max' => Yii::t('app', 'To'),
            'adult_amount' => Yii::t('app', 'Amount of adult'),
            'children_under_12_amount' => Yii::t('app', 'Amount of children (under 12 years old)'),
            'children_under_2_amount' => Yii::t('app', 'Amount of children (under 2 years old)'),
            'room_count' => Yii::t('app', 'Amount of room'),
            'flight_included' => Yii::t('app', 'Flight included'),
            'from_date' => Yii::t('app', 'From date'),
            'to_date' => Yii::t('app', 'To date'),
            'budget' => Yii::t('app', 'Budget'),
            'add_info' => Yii::t('app', 'Add information')
        ];
    }
}
