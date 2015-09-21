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
        $paymentsForm->scenario = 'create';
        $country = new Country();
        $countries = $country->destinationDropdown(Yii::$app->params['depart_countries']);
        if ($paymentsForm->load(Yii::$app->request->post()) and $paymentsForm->validate()) {
            $payment = new Payment();
            $payment->country_id = $paymentsForm->country_id;
            $payment->single_region_cost = $paymentsForm->single_region_cost;
            $payment->multiple_region_cost = $paymentsForm->multiple_region_cost;
            $payment->currency = $paymentsForm->currency;
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

    public function actionEdit($id = null){
        if(is_null($id)){
            return $this->redirect('/admin/board/payments');
        }
        $payment = Payment::findOne($id);
        $paymentsForm = new PaymentsForm();
        $paymentsForm->scenario = 'edit';
        $country = new Country();
        $paymentsForm->country_id = $payment->country_id;
        $paymentsForm->single_region_cost = $payment->single_region_cost;
        $paymentsForm->multiple_region_cost = $payment->multiple_region_cost;
        $paymentsForm->currency = $payment->currency;
        $countries = $country->destinationDropdown(Yii::$app->params['depart_countries']);
        if ($paymentsForm->load(Yii::$app->request->post()) and $paymentsForm->validate()) {
            $payment->country_id = $paymentsForm->country_id;
            $payment->single_region_cost = $paymentsForm->single_region_cost;
            $payment->multiple_region_cost = $paymentsForm->multiple_region_cost;
            $payment->currency = $paymentsForm->currency;
            if($payment->save()) {
                return $this->redirect('/admin/board/payments');
            }else{
                return $this->render('edit', [
                    'paymentsForm' => $paymentsForm,
                    'countries' => $countries
                ]);
            }
        }else{
            return $this->render('edit', [
                'paymentsForm' => $paymentsForm,
                'countries' => $countries,
                'payment' => $payment
            ]);
        }
    }
}