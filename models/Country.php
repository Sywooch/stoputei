<?php
namespace app\models;

use yii\db\ActiveRecord;

class Country extends ActiveRecord
{
    public function getCities(){
        return $this->hasMany(City::className(), ['country_id' => 'id']);
    }

    public function getHotels(){
        return $this->hasMany(Hotel::className(), ['country_id' => 'id']);
    }

    public function getUserTours(){
        return $this->hasMany(UserTour::className(), ['country_id' => 'id']);
    }

    public function destinationDropdown(){
        $countries = self::find()->all();
        $list = [];
        foreach($countries as $key => $country){
            $list[$country->country_id] = $country->name;
        }
        return $list;
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(self::find()->where(['country_id' => $this->country_id])->one()){
                return false;
            }else {
                return true;
            }
        } else {
            return false;
        }
        //test-master
    }
}