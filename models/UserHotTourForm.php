<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class UserHotTourForm extends Model
{
    public $destination;
    public $resort;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination', 'resort'], 'default', 'value' => null]
        ];
    }

    public function attributeLabels()
    {
        return [
            'destination' => Yii::t('app', 'Destination'),
            'resort' => Yii::t('app', 'Resort')
        ];
    }
}
