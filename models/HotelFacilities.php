<?php
namespace app\models;

use yii\db\ActiveRecord;

class HotelFacilities extends ActiveRecord
{
    public static function tableName(){
        return 'hotels_facilities';
    }
}