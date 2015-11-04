<?php

namespace app\modules\admin\controllers;

use app\models\HotToursSearch;
use app\models\ManagerSearch;
use app\models\Pages;
use app\models\TourResponseSearch;
use app\modules\admin\models\AdminEmail;
use app\modules\admin\models\AdminEmailsForm;
use app\modules\admin\models\PaymentSearch;
use app\models\TourResponse;
use app\models\User;
use app\models\UserSearch;
use app\models\UserTour;
use app\models\UserTourSearch;
use app\modules\admin\models\TimeCycles;
use app\modules\admin\models\TimeCyclesForm;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;

class BoardController extends Controller
{
    public function actionUsers(){
        $userSearch = new UserSearch();
        $dataProvider = $userSearch->search(Yii::$app->request->get());

        return $this->render('users',[
           'provider' => $dataProvider,
           'searchModel' => $userSearch,
        ]);
    }

    public function actionManagers(){
        $userSearch = new ManagerSearch();
        $dataProvider = $userSearch->search(Yii::$app->request->get());

        return $this->render('managers',[
            'provider' => $dataProvider,
            'searchModel' => $userSearch,
        ]);
    }

    public function actionTourRequests(){

        $userTourSearch = new UserTourSearch();
        $dataProvider = $userTourSearch->search(Yii::$app->request->get());

        return $this->render('tour-requests',[
            'provider' => $dataProvider,
            'searchModel' => $userTourSearch,
        ]);
    }

    public function actionTourResponses(){
        $tourResponseSearch = new TourResponseSearch();
        $dataProvider = $tourResponseSearch->search(Yii::$app->request->get());

        return $this->render('tour-responses',[
            'provider' => $dataProvider,
            'searchModel' => $tourResponseSearch,
        ]);
    }

    public function actionHotTours(){
        $hotTourSearch = new HotToursSearch();
        $dataProvider = $hotTourSearch->search(Yii::$app->request->get());

        return $this->render('hot-tours',[
            'provider' => $dataProvider,
            'searchModel' => $hotTourSearch,
        ]);
    }

    public function actionEmails(){
        $model = new AdminEmailsForm();
        $adminEmails = AdminEmail::find()->where(['user_id' => Yii::$app->user->identity->getId()])->one();
        $model->email_new_tourist = $adminEmails->email_new_tourist;
        $model->email_new_manager = $adminEmails->email_new_manager;
        $model->email_single_region_pay = $adminEmails->email_single_region_pay;
        $model->email_multiple_region_pay = $adminEmails->email_multiple_region_pay;
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            $adminEmails->email_new_tourist = $model->email_new_tourist;
            $adminEmails->email_new_manager = $model->email_new_manager;
            $adminEmails->email_single_region_pay = $model->email_single_region_pay;
            $adminEmails->email_multiple_region_pay = $model->email_multiple_region_pay;
            $adminEmails->user_id = Yii::$app->user->identity->getId();
            if($adminEmails->save()) {
                Yii::$app->session->setFlash('success', 'SUCCESS');
                return $this->redirect('/admin/board/emails');
            }else{
                return $this->render('emails', [
                    'model' => $model
                ]);
            }
        }else{
            return $this->render('emails', [
                'model' => $model,
            ]);
        }
    }

    public function actionPayments(){
        $paymentSearch = new PaymentSearch();
        $dataProvider = $paymentSearch->search(Yii::$app->request->get());

        return $this->render('payments',[
            'provider' => $dataProvider,
            'searchModel' => $paymentSearch,
        ]);
    }

    public function actionPeriods(){
        $model = new TimeCyclesForm();
        $adminTimeCycles = TimeCycles::find()->one();
        $model->tour_request_life = $adminTimeCycles->tour_request_life;
        $model->tour_response_life = $adminTimeCycles->tour_response_life;
        $model->flight_response_life = $adminTimeCycles->flight_response_life;
        $model->flight_request_life = $adminTimeCycles->flight_request_life;
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            $adminTimeCycles->tour_request_life = $model->tour_request_life;
            $adminTimeCycles->tour_response_life = $model->tour_response_life;
            $adminTimeCycles->flight_response_life = $model->flight_response_life;
            $adminTimeCycles->flight_request_life = $model->flight_request_life;
            if($adminTimeCycles->save()) {
                Yii::$app->session->setFlash('success', 'SUCCESS');
                return $this->redirect('/admin/board/periods');
            }else{
                return $this->render('periods', [
                    'model' => $model
                ]);
            }
        }else{
            return $this->render('periods', [
                'model' => $model,
            ]);
        }
    }

    public function actionPages(){
        $pages = Pages::find()->all();
        return $this->render('pages', [
            'pages' => $pages
        ]);
    }
}