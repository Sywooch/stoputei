<?php
namespace app\models;

use yii\db\ActiveRecord;

class Currency extends ActiveRecord
{
    public function getUserTours(){
        return $this->hasMany(UserTour::className(), ['country_id' => 'id']);
    }
}