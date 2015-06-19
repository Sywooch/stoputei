<?php
namespace app\models;

use yii\db\ActiveRecord;

class Country extends ActiveRecord
{

    public function beforeSave($insert)
    {
        /*if (parent::beforeSave($insert)) {
            if(self::find()->where(['country_id' => $this->country_id])->one()){
                return false;
            }else {
                return true;
            }
        } else {
            return false;
        }*/
    }
}