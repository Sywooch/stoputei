<?php
namespace app\models;

use yii\db\ActiveRecord;

class UserTourRooms extends ActiveRecord
{
    public static function tableName(){
        return 'user_tour_rooms';
    }
}