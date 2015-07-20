<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class FlightResponse extends ActiveRecord
{
    public static function tableName(){
        return 'flight_response';
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

    public function hasResponse($flight_response_id, $manager_id = null){
        if(is_null($manager_id)){
            $manager_id = \Yii::$app->user->identity->getId();
        }
        return self::find()->where(['from_flight_id' => $flight_response_id, 'manager_id' => $manager_id])->count();
    }
}