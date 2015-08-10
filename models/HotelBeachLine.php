<?php
namespace app\models;

use yii\db\ActiveRecord;

class HotelBeachLine extends ActiveRecord
{
    public static function tableName(){
        return 'hotel_beach_line';
    }
}