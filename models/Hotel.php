<?php
namespace app\models;

use yii\db\ActiveRecord;

class Hotel extends ActiveRecord
{
    public function getCountry(){
        return $this->hasOne(Country::className(), ['hotel_id' => 'country_id']);
    }
    public function updateDescription($id, $description = null){
        if($hotel = self::find()->where(['hotel_id' => $id])->one()) {
            $hotel->description = $description;
            $hotel->save();
        }
    }
}