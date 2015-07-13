<?php
namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Expression;

class TourResponse extends ActiveRecord
{
    public static function tableName(){
        return 'tour_response';
    }

    /*public function getCountry(){
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
    }*/

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

    public function hasResponse($tour_response_id, $manager_id = null){
        if(is_null($manager_id)){
            $manager_id = \Yii::$app->user->identity->getId();
        }
        return self::find()->where(['from_tour_id' => $tour_response_id, 'manager_id' => $manager_id])->count();
    }
}