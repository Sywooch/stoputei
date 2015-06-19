<?php
namespace app\models;

use yii\db\ActiveRecord;

class DepartCity extends ActiveRecord
{
    public static function tableName(){
        return 'depart_city';
    }

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