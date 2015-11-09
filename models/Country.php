<?php
namespace app\models;

use yii\db\ActiveRecord;
use app\modules\admin\models\Payment;

class Country extends ActiveRecord
{
    public function getCities(){
        return $this->hasMany(City::className(), ['country_id' => 'id'])->orderBy('name');
    }

    public function getDepartCities(){
        return $this->hasMany(DepartCity::className(), ['country_id' => 'id'])->orderBy('name');
    }

    public function getHotels(){
        return $this->hasMany(Hotel::className(), ['country_id' => 'id']);
    }

    public function getUserTours(){
        return $this->hasMany(UserTour::className(), ['country_id' => 'id']);
    }

    public function getCurrency(){
        return $this->hasOne(Currency::className(), ['country_id' => 'country_id']);
    }

    public function getBill(){
        return $this->hasOne(Payment::className(), ['country_id' => 'country_id']);
    }

    public function destinationDropdown($countries = null){
        if(is_null($countries)) {
            $countries = self::find()->all();
        }else{
            $countries = self::find()->where(['country_id' => $countries])->all();
        }
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