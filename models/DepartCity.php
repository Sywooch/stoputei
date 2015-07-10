<?php
namespace app\models;

use yii\db\ActiveRecord;

class DepartCity extends ActiveRecord
{
    public static function tableName(){
        return 'depart_city';
    }

    public function getUserTours(){
        return $this->hasMany(UserTour::className(), ['depart_city_id' => 'city_id']);
    }

    public function regionDropdown(){
        $cities = self::find()->all();
        $list = [];
        foreach($cities as $key => $city){
            $list[$city->city_id] = $city->name;
        }
        return $list;
    }
}