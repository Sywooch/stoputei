<?php
namespace app\models;

use yii\db\ActiveRecord;

class UserFlightTypes extends ActiveRecord
{
    public static function tableName(){
        return 'user_flight_types';
    }
}