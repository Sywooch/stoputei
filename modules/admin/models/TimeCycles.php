<?php
namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;

class TimeCycles extends ActiveRecord
{
    public static function tableName()
    {
        return 'time_cycles';
    }

    public function attributeLabels()
    {
        return [
            'tour_request_life' => Yii::t('app', 'Tour request time life'),
            'tour_response_life' => Yii::t('app', 'Tour response time life'),
            'flight_response_life' => Yii::t('app', 'Flight response time life'),
            'flight_request_life' => Yii::t('app', 'Flight request time life'),
        ];
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->updated_at = time();
            }
            if($this->isNewRecord){
                $this->created_at = time();
            }
            return true;
        }
        return false;
    }
}