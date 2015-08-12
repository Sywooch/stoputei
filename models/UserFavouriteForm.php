<?php

namespace app\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class UserFavouriteForm extends Model
{
    public $destination;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['destination'], 'default', 'value' => null]
        ];
    }

    public function attributeLabels()
    {
        return [
            'destination' => Yii::t('app', 'Destination')
        ];
    }
}
