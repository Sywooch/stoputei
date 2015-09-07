<?php

namespace app\modules\admin\models;

use Yii;
use yii\base\Model;

/**
 * LoginForm is the model behind the login form.
 */
class PaymentsForm extends Model
{
    public $country_id;
    public $single_region_cost;
    public $multiple_region_cost;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['country_id', 'single_region_cost', 'multiple_region_cost'], 'required'],
            [['single_region_cost', 'multiple_region_cost'], 'integer'],
            ['country_id', 'unique', 'targetClass' => '\app\modules\admin\models\Payment',
                'message' => Yii::t('app','Country has already been taken')],
        ];
    }

    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Country'),
            'single_region_cost' => Yii::t('app', 'Single region cost'),
            'multiple_region_cost' => Yii::t('app', 'Multiple region cost'),
        ];
    }
}
