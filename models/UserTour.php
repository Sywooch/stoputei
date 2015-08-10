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

    public function getCategories(){
        return $this->hasMany(HotelCategory::className(), ['id' => 'category_id'])
            ->viaTable(UserTourCategories::tableName(), ['tour_id' => 'id']);
    }

    public function getNutritions(){
        return $this->hasMany(HotelNutrition::className(), ['nutrition_id' => 'nutrition_id'])
            ->viaTable(UserTourNutritions::tableName(), ['tour_id' => 'id']);
    }

    public function getBeachLines(){
        return $this->hasMany(HotelBeachLine::className(), ['line_id' => 'beach_line_id'])
            ->viaTable(UserTourBeachLines::tableName(), ['tour_id' => 'id']);
    }

    public function getRooms(){
        return $this->hasMany(HotelRoom::className(), ['type_id' => 'room_id'])
            ->viaTable(UserTourRooms::tableName(), ['tour_id' => 'id']);
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
}