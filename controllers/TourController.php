<?php

namespace app\controllers;

use app\models\Country;
use app\models\CreateTourForm;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Hotel;
use app\models\GetTourForm;
use yii\web\View;
use app\models\UserTour;

class TourController extends Controller
{
    public function actionAjaxResortsDropdown(){
        if(Yii::$app->request->isAjax) {
            $country_id = \Yii::$app->request->getQueryParam('country_id', null);
            $country = Country::findOne($country_id);
            $cities = $country->cities;
            $list = [];
            foreach ($cities as $key => $city) {
                $list[] = [
                    'city_id' => $city->city_id,
                    'city_name' => $city->name
                ];
            }
            echo json_encode($list);
        }
    }

    public function actionAjaxHotelsAutocomplete($country_id, $query){
        if(Yii::$app->request->isAjax) {
            if($hotels = Hotel::find()->where(['country_id' => $country_id])->andWhere(['like', 'name', $query])->all()) {
                $list = [];
                foreach ($hotels as $key => $hotel) {
                    $list[] = [
                        'hotel_id' => $hotel->hotel_id,
                        'hotel_name' => $hotel->name
                    ];
                }
                $response = [
                    'hotels' => $list,
                    'status' => 'ok'
                ];
                echo json_encode($response);
            }
        }
    }

    public function actionGetHotelList(){
        $model = new GetTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                if(!empty($model->hotel_id[0])){
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'hotel_id' => $model->hotel_id[0]
                    ])->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
                }else{
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'resort_id' => $model->resort,
                        'star_id' => $model->stars
                    ])->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
                }

                if($hotels){
                    $response = [
                        'html' => $this->renderAjax('partial/hotel-list', ['hotels' => $hotels]),
                        'status' => 'ok',
                        'message' => "Hotel's list",
                        'count' => count($hotels)
                    ];
                    echo Json::encode($response);
                    Yii::$app->end();
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', 'Hotels not found. Please, change search params.'),
                        'count' => 0
                    ];
                    echo Json::encode($response);
                    Yii::$app->end();
                }
            }
        }
    }

    public function actionSubmitTourUser(){
        $model = new GetTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->post()) and $model->validate()) {
                $userTour = new UserTour();
                $userTour->country_id = $model->destination;
                $userTour->resort_id = $model->resort;
                $userTour->hotel_id = $model->hotel_id[0];
                $userTour->depart_city_id = $model->depart_city;
                $userTour->night_min = $model->night_min;
                $userTour->night_max = $model->night_max;
                $userTour->adult_amount = $model->adult_amount;
                $userTour->children_under_12_amount = $model->children_under_12_amount;
                $userTour->children_under_2_amount = $model->children_under_2_amount;
                $userTour->room_count = $model->room_count;
                $userTour->flight_included = $model->flight_included;
                $userTour->from_date = $model->from_date;
                $userTour->to_date = $model->to_date;
                $userTour->budget = $model->budget;
                $userTour->add_info = $model->add_info;
                $userTour->owner_id = Yii::$app->user->identity->getId();
                $userTour->region_owner_id = Yii::$app->user->identity->region_id;
                if($userTour->save()) {
                    $response = [
                        'status' => 'ok',
                        'message' => Yii::t('app', "Congratulations! Just now you have been created your order.")
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'errors' => $model->getErrors()
                    ];
                }
                echo Json::encode($response);
                Yii::$app->end();
            }else{
                $response = [
                    'status' => 'error',
                    'errors' => $model->getErrors()
                ];
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }

    public function actionGetUserTourList(){
        $model = new CreateTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                if($tours = UserTour::find()->where([
                    'country_id' => $model->destination,
                    'resort_id' => $model->resort,
                    'region_owner_id' => Yii::$app->user->identity->region_id
                ])->select('id, country_id, resort_id, created_at, adult_amount, children_under_12_amount, children_under_2_amount')->all()) {
                    $response = [
                        'html' => $this->renderAjax('partial/user-tour-list', ['tours' => $tours]),
                        'status' => 'ok',
                        'message' => "User's tour list",
                        'count' => count($tours)
                    ];
                    echo Json::encode($response);
                    Yii::$app->end();
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', "User's tour not found. Please, change search params."),
                        'count' => 0
                    ];
                    echo Json::encode($response);
                    Yii::$app->end();
                }
            }
        }
    }

    public function actionGetUserTourFullInfo(){
        if(Yii::$app->request->isAjax) {
            $user_tour_id = Yii::$app->request->getQueryParam('user_tour_id', null);
            if(!is_null($user_tour_id)){
                $userTour = UserTour::findOne($user_tour_id);
                $response = [
                    'status' => 'ok',
                    'html' => $this->renderAjax('partial/user-tour-full-info', ['tour' => $userTour]),
                ];
                echo Json::encode($response);
                Yii::$app->end();
            }else{
                $response = [
                    'status' => 'error',
                    'html' => '',
                    'message' => Yii::t('app', "Tour was not found.")
                ];
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }
}
