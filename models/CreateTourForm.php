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
    public $stars;
    public $nutrition;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort', 'stars'], 'required']
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
        ];
    }
}
