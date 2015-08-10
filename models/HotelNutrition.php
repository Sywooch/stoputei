<?php
namespace app\models;

use yii\db\ActiveRecord;

class HotelNutrition extends ActiveRecord
{
    public static function tableName(){
        return 'hotel_nutrition';
    }
}