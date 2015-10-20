<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class UserEditForm extends Model
{
    public $email;
    public $country;
    public $region_id;
    public $role;
    public $company_name;
    public $company_city;
    public $company_address;
    public $company_phone;
    public $company_street;
    public $company_underground;
    public $single_region_paid;
    public $multiple_region_paid;
    public $approved;
    public $single_license_expire;
    public $multiple_license_expire;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email', 'region_id'], 'required'],
            ['role', 'default', 'value' => 1],
            [['company_underground', 'single_license_expire', 'multiple_license_expire'], 'default', 'value' => null],
            [['single_region_paid', 'multiple_region_paid', 'approved'], 'default', 'value' => 0],
            [['company_name', 'company_city', 'company_phone'], 'required', 'when' => function ($model) {
                return $model->role == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"RegistrationForm[role]\"]').val() == 2;
            }"],
            ['company_phone', 'match', 'pattern' => '/^[+0-9_-]+$/', 'message' => Yii::t('app','{attribute} can only contain alphanumeric characters.')]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'country' => Yii::t('app', 'Country'),
            'region_id' => Yii::t('app', 'Region'),
            'role' => Yii::t('app', 'Role'),
            'company_name' => Yii::t('app', 'Company name'),
            'company_city' => Yii::t('app', 'Company city'),
            'company_phone' => Yii::t('app', 'Company phone'),
            'company_address' => Yii::t('app', 'Company address'),
            'company_street' => Yii::t('app', 'Company street'),
            'company_underground' => Yii::t('app', 'Underground'),
            'single_region_paid' => \Yii::t('app', 'Payment "Region"'),
            'multiple_region_paid' => \Yii::t('app', 'Payment "Country"'),
            'approved' => \Yii::t('app', 'Approved'),
            'single_license_expire' => \Yii::t('app', 'License "Region" will be expired to'),
            'multiple_license_expire' => \Yii::t('app', 'License "Country" will be expired to'),
        ];
    }
}
