<?php
namespace app\models;

use yii\db\ActiveRecord;

class Hotel extends ActiveRecord
{

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(self::find()->where(['hotel_id' => $this->hotel_id])->one()){
                return false;
            }else {
                return true;
            }
        } else {
            return false;
        }
    }
}