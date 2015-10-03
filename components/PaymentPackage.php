<?php
namespace app\components;

use yii\base\Widget;
use yii\helpers\Html;

class PaymentPackage extends Widget
{
    public $type;

    public function init()
    {
        parent::init();
        $this->type = '';
        if(\Yii::$app->user->isGuest){
            $this->type = '';
            return;
        }else{
            if(\Yii::$app->user->identity->role == 2){
                if(\Yii::$app->user->identity->multiple_region_paid == 1){
                    $this->type = \Yii::t('app','Payment package "Country"');
                    return;
                }elseif(\Yii::$app->user->identity->single_region_paid == 1){
                    $this->type = \Yii::t('app','Payment package "Region"');
                    return;
                }else{
                    $this->type = Html::a(\Yii::t('app','Payment package is absent.', ['/site/payment']));
                    return;
                }
            }else{
                $this->type = '';
                return;
            }
        }
    }

    public function run()
    {
        return $this->render('payment-package', [
            'type' => $this->type
        ]);
    }
}