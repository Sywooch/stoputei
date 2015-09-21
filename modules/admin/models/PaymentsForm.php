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
    public $currency;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['country_id', 'single_region_cost', 'multiple_region_cost', 'currency'], 'required'],
            [['single_region_cost', 'multiple_region_cost'], 'integer'],
            ['country_id', 'unique', 'targetClass' => '\app\modules\admin\models\Payment',
                'message' => Yii::t('app','Country has already been taken'), 'on' => 'create'],
            ['currency','in','range'=>['USD','EUR','UAH', 'RUB'],'strict'=>true],
        ];
    }

    public function attributeLabels()
    {
        return [
            'country_id' => Yii::t('app', 'Country'),
            'single_region_cost' => Yii::t('app', 'Single region cost'),
            'multiple_region_cost' => Yii::t('app', 'Multiple region cost'),
            'currency' => Yii::t('app', 'Currency'),
        ];
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        //Scenario Values Only Accepted
        $scenarios['edit'] = ['single_region_cost', 'multiple_region_cost', 'currency'];
        return $scenarios;
    }

}
