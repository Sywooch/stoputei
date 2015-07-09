<?php
namespace app\models;

use yii\db\ActiveRecord;

class City extends ActiveRecord
{

    public function getCountry(){
        return $this->hasOne(Country::className(), ['city_id' => 'country_id']);
    }

    public function getUserTours(){
        return $this->hasMany(UserTour::className(), ['resort_id' => 'city_id']);
    }
}