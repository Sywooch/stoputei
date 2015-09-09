<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class AdminEmailsForm extends Model
{
    public $email_new_tourist;
    public $email_new_manager;
    public $email_single_region_pay;
    public $email_multiple_region_pay;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email_new_tourist', 'email_new_manager', 'email_single_region_pay', 'email_multiple_region_pay'], 'boolean']
        ];
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
}
