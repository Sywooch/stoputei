<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class EmailPasswordResetForm extends Model
{

    public $email;


    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['email'], 'required'],
            ['email', 'email'],
            ['email', 'validateExistEmail']
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => Yii::t('app', 'Email'),
        ];
    }

    public function validateExistEmail($attribute, $params)
    {
        if (!User::findByEmail($this->email)) {
            $this->addError($attribute, Yii::t('app', 'This email address doesn\'t exist.'));
        }
    }
}
