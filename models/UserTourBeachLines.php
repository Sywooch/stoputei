<?php
namespace app\models;

use yii\db\ActiveRecord;

class UserTourBeachLines extends ActiveRecord
{
    public static function tableName(){
        return 'user_tour_beach_lines';
    }
}