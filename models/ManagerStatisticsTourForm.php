<?php

namespace app\models;

use Yii;
use yii\base\Model;


class ManagerStatisticsTourForm extends Model
{
    public $country_id;
    public $manager_id;
    public $request_tour_count;
    public $response_tour_count;
    public $hot_tour_count;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['country_id', 'manager_id', 'request_tour_count', 'response_tour_count', 'hot_tour_count'], 'default', 'value' => null]
        ];
    }


    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Request count destination'),
            'request_tour_count' => Yii::t('app', 'Amount of user\'s tour per period'),
            'response_tour_count' => Yii::t('app', 'Amount of manager\'s response tour per period'),
            'hot_tour_count' => Yii::t('app', 'Amount of manager\'s hot tour per period'),
        ];
    }
}
