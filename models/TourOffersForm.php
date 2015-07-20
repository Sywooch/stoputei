<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class TourOffersForm extends Model
{
    public $destination;
    public $resort;
    public $hotel;
    public $hotel_id;
    public $stars;
    public $depart_city;
    public $night_count;
    public $from_date;
    public $to_date;
    public $budget;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'hotel', 'hotel_id', 'stars', 'depart_city', 'night_count', 'from_date', 'to_date', 'budget'],'default', 'value' => null]
        ];
    }


    public function attributeLabels()
    {
        return [
            'destination' => Yii::t('app', 'Destination'),
            'resort' => Yii::t('app', 'Resort'),
            'hotel' => Yii::t('app', 'Hotel'),
            'stars' => Yii::t('app', 'Category'),
            'depart_city' => Yii::t('app', 'Depart city'),
            'from_date' => Yii::t('app', 'From date'),
            'to_date' => Yii::t('app', 'To date'),
            'budget' => Yii::t('app', 'Budget'),
            'night_count' => Yii::t('app', 'Night count'),
        ];
    }
}
