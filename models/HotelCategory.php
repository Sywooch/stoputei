<?php
namespace app\models;

use yii\db\ActiveRecord;

class HotelCategory extends ActiveRecord
{
    public static function tableName(){
        return 'hotel_category';
    }
}