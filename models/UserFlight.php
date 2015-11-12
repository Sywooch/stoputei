<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class UserFlight extends ActiveRecord
{
    public static function tableName(){
        return 'user_flight';
    }

    public function getCountry(){
        return $this->hasOne(Country::className(), ['country_id' => 'country_id']);
    }

    public function getCity(){
        return $this->hasOne(City::className(), ['city_id' => 'city_id']);
    }

    public function getDepartCity(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'depart_city_id']);
    }

    public function getTypes(){
        return $this->hasMany(FlightTypes::className(), ['type_id' => 'type_id'])
            ->viaTable(UserFlightTypes::tableName(), ['flight_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->updated_at = time();
            }
            if($this->isNewRecord){
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }

    public static function getExactlyDate($date){
        switch($date){
            case 0:
                return \Yii::t('app', 'Exactly date');
            case 1:
                return \Yii::t('app', '+-1 day');
            case 2:
                return \Yii::t('app', '+-2 days');
            case 3:
                return \Yii::t('app', '+-3 days');
            default:
                return \Yii::t('app', '+-3 days');
        }
    }

    public static function getFlightType($type){
        switch($type){
            case 0:
                return \Yii::t('app', 'Direct flight');
            case 1:
                return \Yii::t('app', 'Regular flight');
            default:
                return \Yii::t('app', 'Direct flight');
        }
    }
}