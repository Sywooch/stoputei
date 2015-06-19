<?php
namespace app\models;

use yii\db\ActiveRecord;

class City extends ActiveRecord
{

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if(self::find()->where(['city_id' => $this->city_id])->one()){
                return false;
            }else {
                return true;
            }
        } else {
            return false;
        }
    }
}