<?php
namespace app\models;

use yii\db\ActiveRecord;

class UserTourNutritions extends ActiveRecord
{
    public static function tableName(){
        return 'user_tour_nutritions';
    }
}