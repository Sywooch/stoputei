<?php
namespace app\models;

use yii\db\ActiveRecord;

class UserTourCategories extends ActiveRecord
{
    public static function tableName(){
        return 'user_tour_categories';
    }
}