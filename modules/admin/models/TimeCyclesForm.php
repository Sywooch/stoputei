<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class TimeCyclesForm extends Model
{
    public $tour_request_life;
    public $tour_response_life;
    public $flight_response_life;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['tour_request_life', 'tour_response_life', 'flight_response_life'], 'integer']
        ];
    }

    public function attributeLabels()
    {
        return [
            'tour_request_life' => Yii::t('app', 'Tour request time life'),
            'tour_response_life' => Yii::t('app', 'Tour response time life'),
            'flight_response_life' => Yii::t('app', 'Flight response time life'),
        ];
    }
}
