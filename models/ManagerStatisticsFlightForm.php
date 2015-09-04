<?php

namespace app\models;

use Yii;
use yii\base\Model;


class ManagerStatisticsFlightForm extends Model
{
    public $country_id;
    public $manager_id;
    public $request_flight_count;
    public $response_flight_count;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['country_id', 'manager_id', 'request_flight_count', 'response_flight_count'], 'default', 'value' => null]
        ];
    }


    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Request count destination'),
            'request_flight_count' => Yii::t('app', 'Amount of user\'s flight per period'),
            'response_flight_count' => Yii::t('app', 'Amount of manager\'s response flight per period'),
        ];
    }
}
