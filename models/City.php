<?php
namespace app\models;

use yii\db\ActiveRecord;

class City extends ActiveRecord
{

    public function getCountry(){
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
    }

    public function getUserTours(){
        return $this->hasMany(UserTour::className(), ['resort_id' => 'city_id']);
    }
    public function destinationCityDropdown($countries = null){
        if(is_null($countries)) {
            $cities = self::find()->orderBy('name')->all();
        }else{
            $cities = self::find()->where(['country_id' => $countries])->orderBy('name')->all();
        }
        $list = [];
        foreach($cities as $key => $city){
            $list[$city->city_id] = $city->name;
        }
        return $list;
    }
}