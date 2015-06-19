<?php
namespace app\models;

use yii\db\ActiveRecord;

class HotelComment extends ActiveRecord
{
    public static function tableName(){
        return 'hotel_comment';
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(self::find()->where(['hotel_id' => $this->hotel_id, 'user_name' => $this->user_name, 'rate' => $this->rate])->one()){
                return false;
            }else {
                return true;
            }
        } else {
            return false;
        }
    }
}