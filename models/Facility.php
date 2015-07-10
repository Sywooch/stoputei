<?php
namespace app\models;

use yii\db\ActiveRecord;

class Facility extends ActiveRecord
{
    public static function tableName(){
        return 'facility';
    }

    public function getHotels(){
        return $this->hasMany(Hotel::className(), ['hotel_id' => 'hotel_id'])
            ->viaTable(HotelFacilities::tableName(), ['facility_id' => 'id']);
    }
}