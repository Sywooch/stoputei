<?php
namespace app\modules\admin\models;

use yii\db\ActiveRecord;
use Yii;

class AdminEmail extends ActiveRecord
{
    public static function tableName()
    {
        return 'admin_emails';
    }

    public function attributeLabels()
    {
        return [
            'email_new_tourist' => Yii::t('app', 'Get email about new tourists'),
            'email_new_manager' => Yii::t('app', 'Get email about new managers'),
            'email_single_region_pay' => Yii::t('app', 'Get email about unlock manager account'),
            'email_multiple_region_pay' => Yii::t('app', 'Get email about new payment "All country"'),
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