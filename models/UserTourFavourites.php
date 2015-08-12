<?php
namespace app\models;

use yii\db\ActiveRecord;

class UserTourFavourites extends ActiveRecord
{
    public static function tableName(){
        return 'user_tour_favourites';
    }

    public static function primaryKey(){
        return 'tour_id';
    }

    public function isFavourite($tour_id, $user_id = null){
        if(is_null($user_id)){
            $user_id = \Yii::$app->user->identity->getId();
        }
        return self::find()->where(['tour_id' => $tour_id, 'user_id' => $user_id])->count();
    }
}