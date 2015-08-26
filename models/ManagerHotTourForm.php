<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ManagerHotTourForm extends Model
{
    public $destination;
    public $resort;
    public $hotel;
    public $hotel_id;
    public $id;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'hotel_id', 'id'], 'default', 'value' => null]
        ];
    }

    public function attributeLabels()
    {
        return [
            'destination' => Yii::t('app', 'Destination'),
            'resort' => Yii::t('app', 'Resort'),
            'hotel' => Yii::t('app', 'Hotel'),
            'id' => Yii::t('app', 'Tour\s number'),
        ];
    }
}
