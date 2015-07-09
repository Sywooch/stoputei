<?php
namespace app\models;

use yii\db\ActiveRecord;

class DepartCity extends ActiveRecord
{
    public static function tableName(){
        return 'depart_city';
    }

    public function regionDropdown(){
        $cities = self::find()->all();
        $list = [];
        foreach($cities as $key => $city){
            $list[$city->city_id] = $city->name;
        }
        return $list;
    }

    public function beforeSave($insert)
    {
        /*if (parent::beforeSave($insert)) {
            if(self::find()->where(['city_id' => $this->city_id])->one()){
                return false;
            }else {
                return true;
            }
        } else {
            return false;
        }*/
    }
}