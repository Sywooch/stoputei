<?php

namespace app\controllers;

use app\models\City;
use app\models\CreateHotTourForm;
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
use app\models\DepartCity;
use app\models\TourResponse;
use app\models\Country;
use app\models\CreateTourForm;
use app\models\TourOffersForm;

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

    public function actionAjaxHotelsAutocomplete($country_id, $resort_id, $query){
        if(Yii::$app->request->isAjax) {
            if($hotels = Hotel::find()->where(['country_id' => $country_id, 'resort_id' => $resort_id])->andWhere(['like', 'name', $query])->all()) {
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
            }else{
                $response = [
                    'hotels' => [],
                    'status' => 'ok'
                ];
            }
            echo json_encode($response);
        }
    }

    public function actionAjaxHotelsAutocompleteManager($country_id, $resort_id, $query){
        if(Yii::$app->request->isAjax) {
            if($hotels = Hotel::find()->where(['country_id' => $country_id, 'resort_id' => $resort_id])->andWhere(['like', 'name', $query])->all()) {
                $list = [];
                foreach ($hotels as $key => $hotel) {
                    $list[] = [
                        'hotel_id' => $hotel->hotel_id,
                        'hotel_name' => $hotel->name
                    ];
                }
                if(!empty($list)) {
                    $response = [
                        'hotels' => $list,
                        'status' => 'ok'
                    ];
                }else{
                    $response = [
                        'hotels' => [],
                        'status' => 'ok'
                    ];
                }
                echo json_encode($response);
            }
        }
    }

    public function actionGetHotelList(){
        $model = new GetTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                $filter_type = 'user-type';
                $query = [];
                if(!empty($model->stars)){
                    $query['star_id'] = $model->stars;
                }
                if(!empty($model->hotel_id[0])){
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'hotel_id' => $model->hotel_id[0]
                    ])->andWhere($query)->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
                }else{
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'resort_id' => $model->resort
                    ])->andWhere($query)->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
                }

                if($hotels){
                    $response = [
                        'html' => $this->renderAjax('partial/hotel-list', ['hotels' => $hotels, 'filter_type' => $filter_type]),
                        'status' => 'ok',
                        'message' => "Hotel's list",
                        'count' => count($hotels)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', 'Hotels not found. Please, change search params.'),
                        'count' => 0
                    ];
                }
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }

    public function actionGetHotelManagerList(){
        $filter_type = \Yii::$app->request->getQueryParam('filter_type', null);
        if($filter_type=='manager-response') {
            $model = new CreateTourForm();
        }else{
            $model = new CreateHotTourForm();
        }
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                $query = [];
                if(!empty($model->stars)){
                    $query['star_id'] = $model->stars;
                }
                if(!empty($model->hotel_id[0])){
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'hotel_id' => $model->hotel_id[0]
                    ])->andWhere($query)->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
                }else{
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'resort_id' => $model->resort
                    ])->andWhere($query)->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
                }

                if($hotels){
                    $response = [
                        'html' => $this->renderAjax('partial/hotel-list', ['hotels' => $hotels, 'filter_type' => $filter_type]),
                        'status' => 'ok',
                        'message' => "Hotel's list",
                        'count' => count($hotels)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', 'Hotels not found. Please, change search params.'),
                        'count' => 0
                    ];
                }
                echo Json::encode($response);
                Yii::$app->end();
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
                $userTour->night_max = $model->night_max;
                $userTour->hotel_type = $model->hotel_type;
                $userTour->beach_line = $model->beach_line;
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
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Just now you have been created your order.").'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-6 create-one-more-tour" data-dismiss="modal">'.Yii::t('app', 'Close').'</button>
                                        <button type="button" class="btn btn-primary col-xs-6" data-dismiss="modal">'.Yii::t('app', 'Create same tour').'</button>
                                      </div>'
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
                ])->all()) {
                    $response = [
                        'html' => $this->renderAjax('partial/user-tour-list', ['tours' => $tours]),
                        'status' => 'ok',
                        'message' => "User's tour list",
                        'count' => count($tours)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', "User's tour not found. Please, change search params."),
                        'count' => 0
                    ];
                }
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }

    public function actionGetUserTourFullInfo(){
        if(Yii::$app->request->isAjax) {
            $user_tour_id = Yii::$app->request->getQueryParam('user_tour_id', null);
            $filter_type = Yii::$app->request->getQueryParam('filter_type', null);
            if(!is_null($user_tour_id)){
                $userTour = UserTour::findOne($user_tour_id);
                $createTourForm = new CreateTourForm();
                $departCity = new DepartCity();
                $city = new City();
                $departCityThereDropdown = $departCity->regionDropdown();
                $dropdownDestination = [$userTour->country_id => $userTour->country->name];
                $dropdownResort = [$userTour->resort_id => $userTour->city->name];
                $createTourForm->user_id = $userTour->owner_id;
                $createTourForm->from_tour_id = $userTour->id;
                $createTourForm->flight_included = $userTour->flight_included;
                $createTourForm->adult_amount = $userTour->adult_amount;
                $createTourForm->children_under_12_amount = $userTour->children_under_12_amount;
                $createTourForm->children_under_2_amount = $userTour->children_under_2_amount;
                $destinationCityDropdown = $city->destinationCityDropdown($userTour->country_id);

                //get hotels list
                if(!empty($userTour->hotel_id)){
                    $createTourForm->hotel_id = $userTour->hotel_id;
                    $createTourForm->hotel = $userTour->hotel->name;
                    $hotels = Hotel::find()->where([
                        'country_id' => $userTour->country_id,
                        'hotel_id' => $userTour->hotel_id
                    ])->all();
                    $dropdownHotel = [$userTour->hotel_id => $userTour->hotel->name];
                }else{
                    $hotels = Hotel::find()->where([
                        'country_id' => $userTour->country_id,
                        'resort_id' => $userTour->resort_id,
                        //'star_id' => $userTour->stars
                    ])->all();
                    $dropdownHotel = [];
                }
                $response = [
                    'status' => 'ok',
                    'html' => $this->renderAjax('partial/user-tour-full-info', ['tour' => $userTour]),
                    'hotels' => $this->renderAjax('partial/hotel-list', ['hotels' => $hotels, 'filter_type' => $filter_type]),
                    'form' => $this->renderAjax('partial/manager-tour-response-form', [
                        'CreateTourForm' => $createTourForm,
                        'dropdownDestination' => $dropdownDestination,
                        'dropdownResort' => $dropdownResort,
                        'departCityThereDropdown' => $departCityThereDropdown,
                        'dropdownHotel' => $dropdownHotel,
                        'destinationCityDropdown' => $destinationCityDropdown
                    ]),
                    'tab_name' => Yii::t('app', 'Creating tour')
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'html' => '',
                    'message' => Yii::t('app', "Tour was not found.")
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionGetUserTourRequest(){
        if(Yii::$app->request->isAjax) {
            $userTours = UserTour::find()->where([
                'region_owner_id' => Yii::$app->user->identity->region_id
            ])->select('id, country_id, resort_id, hotel_id, created_at, adult_amount, children_under_12_amount, children_under_2_amount')->all();
            if ($userTours) {
                $createTourForm = new CreateTourForm();
                $response = [
                    'status' => 'ok',
                    'html' => $this->renderAjax('partial/user-tour-list', ['tours' => $userTours]),
                    'form' => $this->renderAjax('partial/manager-tour-response-form-empty', [
                        'CreateTourForm' => $createTourForm
                    ]),
                    'tab_name' => Yii::t('app', 'Tour from users')
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'html' => '',
                    'message' => 'Statistics'
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionCreateTourManager(){
        $model = new CreateTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->post()) and $model->validate()) {
                $tourResponse = new TourResponse();
                $tourResponse->setAttributes(Yii::$app->request->post());
                $tourResponse->country_id = $model->destination;
                $tourResponse->city_id = $model->resort;
                if(!empty($model->hotel_id[0])) {
                    $tourResponse->hotel_id = $model->hotel_id[0];
                }else{
                    $tourResponse->hotel_id = null;
                }
                $tourResponse->night_count = $model->night_count;
                $tourResponse->adult_amount = $model->adult_amount;
                $tourResponse->children_under_12_amount = $model->children_under_12_amount;
                $tourResponse->children_under_2_amount = $model->children_under_2_amount;
                $tourResponse->room_count = $model->room_count;
                $tourResponse->flight_included = $model->flight_included;
                $tourResponse->depart_city_there = $model->depart_city_there;
                $tourResponse->depart_city_from_there = $model->depart_city_from_there;
                $tourResponse->from_date = $model->from_date;
                $tourResponse->to_date = $model->to_date;
                $tourResponse->voyage_there = $model->voyage_there;
                $tourResponse->voyage_from_there = $model->voyage_from_there;
                $tourResponse->voyage_through_city_there = $model->voyage_through_city_there;
                $tourResponse->voyage_through_city_from_there = $model->voyage_through_city_from_there;
                $tourResponse->add_payment = $model->add_payment;
                $tourResponse->visa = $model->visa;
                $tourResponse->oil_tax = $model->oil_tax;
                $tourResponse->tickets_exist = $model->tickets_exist;
                $tourResponse->medicine_insurance = $model->medicine_insurance;
                $tourResponse->charge_manager = $model->charge_manager;
                $tourResponse->tour_cost = $model->tour_cost;
                $tourResponse->user_id = $model->user_id;
                $tourResponse->from_tour_id = $model->from_tour_id;
                $tourResponse->manager_id = Yii::$app->user->identity->getId();
                if($tourResponse->save()) {
                    $response = [
                        'status' => 'ok',
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Just now you have been created your response to tourist. Warning! All responses are actually only 2 days.").'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-6 create-one-more-manager-response" data-dismiss="modal">'.Yii::t('app', 'Create new one').'</button>
                                        <button type="button" class="btn btn-primary col-xs-6 to-request-list">'.Yii::t('app', 'Back to request list').'</button>
                                      </div>'
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
                    'errors' => $model->getErrors(),
                    'model' => $model
                ];
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }

    public function actionAjaxGetEmptyTourForm(){
        if(Yii::$app->request->isAjax) {
            $GetTourForm = new GetTourForm();
            $GetTourForm->flight_included = 1;
            $country = new Country();
            $departCity = new DepartCity();
            $destinationDropdown = $country->destinationDropdown();
            $departCityDropdown = $departCity->regionDropdown();
            $departCountryDropdown = $destinationDropdown;
            $response = [
                'status' => 'ok',
                'form' => $this->renderAjax('partial/user-tour-request-form', [
                    'destinationDropdown' => $destinationDropdown,
                    'GetTourForm' => $GetTourForm,
                    'departCityDropdown' => $departCityDropdown,
                    'resortDropdown' => [],
                    'departCountryDropdown' => $departCountryDropdown
                ])
            ];
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxCreateOneMoreManagerResponse(){
        if(Yii::$app->request->isAjax) {
            $createTourForm = new CreateTourForm();
            if($createTourForm->load(Yii::$app->request->get())){
                $userTour = UserTour::findOne($createTourForm->from_tour_id);
                $createTourForm = new CreateTourForm();
                $departCity = new DepartCity();
                $city = new City();
                $departCityThereDropdown = $departCity->regionDropdown();
                $dropdownDestination = [$userTour->country_id => $userTour->country->name];
                $dropdownResort = [$userTour->resort_id => $userTour->city->name];
                $createTourForm->flight_included = $userTour->flight_included;
                $destinationCityDropdown = $city->destinationCityDropdown($userTour->country_id);

                if(!empty($userTour->hotel_id)){
                    $dropdownHotel = [$userTour->hotel_id => $userTour->hotel->name];
                }else{
                    $dropdownHotel = [];
                }
                $response = [
                    'status' => 'ok',
                    'form' => $this->renderAjax('partial/manager-tour-response-form', [
                        'CreateTourForm' => $createTourForm,
                        'dropdownDestination' => $dropdownDestination,
                        'dropdownResort' => $dropdownResort,
                        'departCityThereDropdown' => $departCityThereDropdown,
                        'dropdownHotel' => $dropdownHotel,
                        'destinationCityDropdown' => $destinationCityDropdown
                    ]),
                    'tab_name' => Yii::t('app', 'Tour from users')
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'html' => '',
                    'message' => Yii::t('app', "Tour was not found.")
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxGetOffersList(){
        $model = new TourOffersForm();
        if(Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->get())) {
                $query = [];
                if(!empty($model->from_date)){
                    $query['from_date'] = $model->from_date;
                }
                if(!empty($model->to_date)){
                    $query['to_date'] = $model->to_date;
                }
                if(!empty($model->hotel_id)){
                    $query['hotel_id'] = $model->hotel_id;
                }
                if($model->night_count != 0){
                    $query['hotel_id'] = $model->hotel_id;
                }
                $tourResponses = TourResponse::find()->where([
                    'city_id' => $model->resort,
                    'depart_city_there' => $model->depart_city,
                    'user_id' => Yii::$app->user->identity->getId()
                ])->andWhere($query)->all();
                if(!empty($tourResponses)) {
                    $response = [
                        'status' => 'ok',
                        'model' => $model,
                        'tours' => $this->renderAjax('partial/user-tour-response-list', ['tourUserResponse' => $tourResponses]),
                        'count' => count($tourResponses)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', 'Hotels not found. Please, change search params.'),
                        'count' => 0
                    ];
                }
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }

    public function actionCreateHotTourManager(){
        $model = new CreateHotTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->post()) and $model->validate()) {
                $tourResponse = new TourResponse();
                $tourResponse->country_id = $model->destination;
                $tourResponse->city_id = $model->resort;
                if(!empty($model->hotel_id[0])) {
                    $tourResponse->hotel_id = $model->hotel_id[0];
                }else{
                    $tourResponse->hotel_id = null;
                }
                $tourResponse->night_count = $model->night_count;
                $tourResponse->adult_amount = $model->adult_amount;
                $tourResponse->children_under_12_amount = $model->children_under_12_amount;
                $tourResponse->children_under_2_amount = $model->children_under_2_amount;
                $tourResponse->room_count = $model->room_count;
                $tourResponse->flight_included = $model->flight_included;
                $tourResponse->depart_city_there = $model->depart_city_there;
                $tourResponse->depart_city_from_there = $model->depart_city_from_there;
                $tourResponse->from_date = $model->from_date;
                $tourResponse->to_date = $model->to_date;
                $tourResponse->voyage_there = $model->voyage_there;
                $tourResponse->voyage_from_there = $model->voyage_from_there;
                $tourResponse->voyage_through_city_there = $model->voyage_through_city_there;
                $tourResponse->voyage_through_city_from_there = $model->voyage_through_city_from_there;
                $tourResponse->add_payment = $model->add_payment;
                $tourResponse->visa = $model->visa;
                $tourResponse->oil_tax = $model->oil_tax;
                $tourResponse->tickets_exist = $model->tickets_exist;
                $tourResponse->medicine_insurance = $model->medicine_insurance;
                $tourResponse->charge_manager = $model->charge_manager;
                $tourResponse->tour_cost = $model->tour_cost;
                $tourResponse->is_hot_tour = $model->is_hot_tour;
                $tourResponse->manager_id = Yii::$app->user->identity->getId();
                if($tourResponse->save()) {
                    $response = [
                        'status' => 'ok',
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Just now you have been created your response to tourist. Warning! All responses are actually only 2 days.").'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-12 create-one-more-hot-tour" data-dismiss="modal">'.Yii::t('app', 'Create one more hot tour').'</button>
                                      </div>'
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
                    'errors' => $model->getErrors(),
                    'model' => $model
                ];
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }

    public function actionCreateOneMoreHotTour(){
        if(Yii::$app->request->isAjax) {
            $CreateHotTourForm = new CreateHotTourForm();
            $country = new Country();
            $departCity = new DepartCity();
            $destinationDropdown = $country->destinationDropdown();
            $departCityThereDropdown = $departCity->regionDropdown();
            $response = [
                'status' => 'ok',
                'form' => $this->renderAjax('partial/manager-create-hot-tour-form',[
                  'CreateHotTourForm' => $CreateHotTourForm,
                  'dropdownDestination' => $destinationDropdown,
                  'departCityThereDropdown' => $departCityThereDropdown
                ])
            ];
            echo Json::encode($response);
            Yii::$app->end();
        }
    }
}
