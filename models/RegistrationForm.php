<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * RegistrationForm is the model behind the registration form.
 */
class RegistrationForm extends Model
{
    public $email;
    public $password;
    public $password_repeat;
    public $country;
    public $region_id;
    public $role;
    public $company_name;
    public $company_city;
    public $company_address;
    public $company_phone;
    public $company_street;
    public $company_underground;
    public $consent;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['password', 'password_repeat', 'email', 'region_id'], 'required'],
            ['password', 'compare'],
            ['password', 'string', 'length' => [5, 20]],
            ['email', 'trim'],
            ['email', 'unique', 'targetClass' => '\app\models\User',
                'message' => Yii::t('app','Email has already been taken')],
            ['email', 'email'],
            [['consent'], 'boolean'],
            ['role', 'default', 'value' => 1],
            ['company_underground', 'default', 'value' => null],
            ['consent', 'required', 'requiredValue' => true, 'message' => Yii::t('app','{attribute} must be checked.'), 'when' => function ($model) {
                return $model->role == 1;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"RegistrationForm[role]\"]:checked').val() == 1;
            }"],
            [['company_name', 'company_city', 'company_phone'], 'required', 'when' => function ($model) {
                return $model->role == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"RegistrationForm[role]\"]:checked').val() == 2;
            }"],
            ['company_phone', 'match', 'pattern' => '/^[+0-9_-]+$/', 'message' => Yii::t('app','{attribute} can only contain alphanumeric characters.')]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
            'password' => Yii::t('app', 'Password'),
            'password_repeat' => Yii::t('app', 'Confirm Password'),
            'country' => Yii::t('app', 'Country'),
            'region_id' => Yii::t('app', 'Region'),
            'role' => Yii::t('app', 'Role'),
            'consent' => Yii::t('app', 'Consent'),
            'company_name' => Yii::t('app', 'Company name'),
            'company_city' => Yii::t('app', 'Company city'),
            'company_phone' => Yii::t('app', 'Company phone'),
            'company_address' => Yii::t('app', 'Company address'),
            'company_street' => Yii::t('app', 'Company street'),
            'company_underground' => Yii::t('app', 'Underground'),
        ];
    }
}
