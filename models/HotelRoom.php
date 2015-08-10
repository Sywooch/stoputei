<?php
namespace app\models;

use yii\db\ActiveRecord;

class HotelRoom extends ActiveRecord
{
    public static function tableName(){
        return 'hotel_room';
    }
}