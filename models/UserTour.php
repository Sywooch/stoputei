<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class UserTour extends ActiveRecord
{
    public static function tableName(){
        return 'user_tour';
    }

    public function getCountry(){
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
    }

    public function getCity(){
        return $this->hasOne(City::className(), ['city_id' => 'resort_id']);
    }

    public function getHotel(){
        return $this->hasOne(Hotel::className(), ['hotel_id' => 'hotel_id']);
    }

    public function getDepartCity(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'depart_city_id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->updated_at = new Expression('NOW()');
            }
            if($this->isNewRecord){
                $this->created_at = new Expression('NOW()');
            }
            return true;
        }
        return false;
    }
}