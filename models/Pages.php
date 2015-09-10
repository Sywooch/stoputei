<?php
namespace app\models;

use yii\db\ActiveRecord;

class Pages extends ActiveRecord
{
    public static function tableName()
    {
        return 'pages';
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