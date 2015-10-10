<?php
namespace app\models;

use yii\db\ActiveRecord;

class FlightTypes extends ActiveRecord
{
    public static function tableName(){
        return 'flight_types';
    }
}