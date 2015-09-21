<?php
namespace app\models;

use yii\db\ActiveRecord;

class Hotel extends ActiveRecord
{
    public function getCountry(){
        return $this->hasOne(Country::className(), ['hotel_id' => 'country_id']);
    }

    public function getUserTours(){
        return $this->hasMany(UserTour::className(), ['hotel_id' => 'hotel_id']);
    }

    public function getTestimonials(){
        return $this->hasMany(HotelComment::className(), ['hotel_id' => 'hotel_id']);
    }

    public function getFacilities(){
        return $this->hasMany(Facility::className(), ['id' => 'facility_id'])
            ->viaTable(HotelFacilities::tableName(), ['hotel_id' => 'hotel_id'])
            ->orderBy(['category_type' => SORT_ASC]);
    }

    public function updateDescription($id, $description = null){
        if($hotel = self::find()->where(['hotel_id' => $id])->one()) {
            $hotel->description = $description;
            $hotel->save();
        }
    }
}