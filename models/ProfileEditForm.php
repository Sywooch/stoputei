<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class ProfileEditForm extends Model
{
    public $id;
    public $email;
    public $password;
    public $password_repeat;
    public $country;
    public $region_id;
    public $role;
    public $company_name;
    public $company_city;
    public $company_phone;
    public $company_address;
    public $company_street;
    public $company_underground;
    public $email_about_tour;
    public $email_about_hot_tour;
    public $email_about_flight;
    public $email_about_user_tour;
    public $email_about_user_flight;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['region_id'], 'required'],
            ['password', 'compare'],
            ['password', 'string', 'length' => [5, 20]],
            [['email_about_hot_tour', 'email_about_tour', 'email_about_flight', 'email_about_user_tour', 'email_about_user_flight'], 'default', 'value' => 0],
            [['company_address', 'company_street', 'company_underground', 'password', 'password_repeat'], 'default', 'value' => null],
            [['company_name', 'company_city', 'company_phone'], 'required', 'when' => function ($model) {
                return $model->role == 2;
            }, 'whenClient' => "function (attribute, value) {
                return $('[name=\"ProfileEditForm[role]\"]:checked').val() == 2;
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
            'email_about_tour' => Yii::t('app', 'Receive newsletter about new tour\'s offer'),
            'email_about_hot_tour' => Yii::t('app', 'Receive newsletter about new hot tour\'s offer'),
            'email_about_flight' => Yii::t('app', 'Receive newsletter about new flight\'s offer'),
            'email_about_user_tour' => Yii::t('app', 'Receive newsletter about new users\'s requests'),
            'email_about_user_flight' => Yii::t('app', 'Receive newsletter about new flight\'s flights'),
            'company_name' => Yii::t('app', 'Company name'),
            'company_city' => Yii::t('app', 'Company city'),
            'company_phone' => Yii::t('app', 'Company phone'),
            'company_address' => Yii::t('app', 'Company address'),
            'company_street' => Yii::t('app', 'Company street'),
            'company_underground' => Yii::t('app', 'Underground'),
        ];
    }
}
