<?php

namespace app\modules\admin\controllers;

use app\models\Country;
use app\modules\admin\models\Payment;
use app\modules\admin\models\PaymentsForm;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;

class PaymentsController extends Controller
{
    public function actionNew(){
        $paymentsForm = new PaymentsForm();
        $country = new Country();
        $countries = $country->destinationDropdown(Yii::$app->params['depart_countries']);
        if ($paymentsForm->load(Yii::$app->request->post()) and $paymentsForm->validate()) {
            $payment = new Payment();
            $payment->country_id = $paymentsForm->country_id;
            $payment->single_region_cost = $paymentsForm->single_region_cost;
            $payment->multiple_region_cost = $paymentsForm->multiple_region_cost;
            if($payment->save()) {
                return $this->redirect('/admin/board/payments');
            }else{
                return $this->render('new', [
                    'paymentsForm' => $paymentsForm,
                    'countries' => $countries
                ]);
            }
        }else{
            return $this->render('new', [
                'paymentsForm' => $paymentsForm,
                'countries' => $countries
            ]);
        }
    }
}