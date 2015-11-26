<?php

namespace app\controllers;

use app\components\EventHandler;
use app\components\MailerEvent;
use app\models\UserFavouriteForm;
use app\models\UserHotTourForm;
use app\models\UserTourBeachLines;
use app\models\UserTourCategories;
use app\models\UserTourFavourites;
use app\models\UserTourNutritions;
use app\models\UserTourRooms;
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
use app\models\City;
use app\models\CreateHotTourForm;
use app\models\ManagerHotTourForm;
use app\models\ManagerOffersForm;
use app\modules\admin\models\TimeCycles;

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

    public function actionAjaxDepartCitiesDropdown(){
        if(Yii::$app->request->isAjax) {
            $country_id = \Yii::$app->request->getQueryParam('country_id', null);
            $country = Country::findOne($country_id);
            $cities = $country->departCities;
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

    public function actionAjaxResortsDropdownForFilter(){
        if(Yii::$app->request->isAjax) {
            $country_id = \Yii::$app->request->getQueryParam('country_id', null);
            if($country_id == 'all') {
                $cities = [];
            }else{
                $country = Country::findOne($country_id);
                $cities = $country->cities;
            }
            $list[] = [
                'city_id' => '',
                'city_name' => Yii::t('app', 'All cities')
            ];
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
            if($hotels = Hotel::find()->where(['country_id' => $country_id, 'resort_id' => $resort_id])->andWhere(['like', 'name', $query])->orderBy('name')->all()) {
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
            if($hotels = Hotel::find()->where(['country_id' => $country_id, 'resort_id' => $resort_id])->andWhere(['like', 'name', $query])->orderBy('name')->all()) {
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
                $query1 = [];
                if(!empty($model->stars)){
                    $query['star_id'] = $model->stars;
                }
                if(!empty($model->letter_filter)){
                    foreach($model->letter_filter as $letter){
                        $query1[] = $letter.'%';
                    }
                }else{
                    $query1[] = '%';
                }
                if(!empty($model->hotel_id[0])){
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'hotel_id' => $model->hotel_id[0]
                    ])->andWhere($query)->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
                }else{
                    $hotels = Hotel::find()->where([
                        'country_id' => $model->destination,
                        'resort_id' => $model->resort,
                    ])->andWhere($query)->andWhere(['OR like', 'name', $query1, false])->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
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
                $query1= [];
                if(!empty($model->stars)){
                    $query['star_id'] = $model->stars;
                }

                if(!empty($model->letter_filter)){
                    foreach($model->letter_filter as $letter){
                        $query1[] = $letter.'%';
                    }
                }else{
                    $query1[] = '%';
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
                    ])->andWhere($query)->andWhere(['OR like', 'name', $query1, false])->select('id, hotel_id, hotel_rate, name, country_name, resort, star_id')->all();
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
                $userTour->night_min = $model->night_min;
                $userTour->night_max = $model->night_max;
                $userTour->hotel_type = $model->hotel_type;
                $userTour->adult_amount = $model->adult_amount;
                $userTour->children_under_12_amount = $model->children_under_12_amount;
                $userTour->children_under_2_amount = $model->children_under_2_amount;
                $userTour->room_count = $model->room_count;
                $userTour->flight_included = $model->flight_included;
                $userTour->from_date = $model->from_date;
                $userTour->exactly_date = $model->exactly_date;
                $userTour->budget = $model->budget;
                $userTour->add_info = $model->add_info;
                $userTour->owner_id = Yii::$app->user->identity->getId();
                $userTour->region_owner_id = Yii::$app->user->identity->region_id;
                if($userTour->save()) {
                    if(!empty($model->stars)){
                        foreach($model->stars as $star){
                            $userTourCategories = new UserTourCategories();
                            $userTourCategories->tour_id = $userTour->id;
                            $userTourCategories->category_id = $star;
                            $userTourCategories->save();
                            unset($userTourCategories);
                        }
                    }
                    if(!empty($model->beach_line)){
                        foreach($model->beach_line as $beach_line){
                            $userTourBeachLines = new UserTourBeachLines();
                            $userTourBeachLines->tour_id = $userTour->id;
                            $userTourBeachLines->beach_line_id = $beach_line;
                            $userTourBeachLines->save();
                            unset($userTourBeachLines);
                        }
                    }
                    if(!empty($model->nutrition)){
                        foreach($model->nutrition as $nutrition){
                            $userTourNutritions = new UserTourNutritions();
                            $userTourNutritions->tour_id = $userTour->id;
                            $userTourNutritions->nutrition_id = $nutrition;
                            $userTourNutritions->save();
                            unset($userTourNutritions);
                        }
                    }
                    if(!empty($model->room_type)){
                        foreach($model->room_type as $room){
                            $userTourRooms = new UserTourRooms();
                            $userTourRooms->tour_id = $userTour->id;
                            $userTourRooms->room_id = $room;
                            $userTourRooms->save();
                            unset($userTourRooms);
                        }
                    }
                    $timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
                    $tourRequestLifeInSec = $timeCycle->tour_request_life*3600;
                    $response = [
                        'status' => 'ok',
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Just now you have been created your order. It will be actually to ").Yii::$app->formatter->asDate((time()+$tourRequestLifeInSec),'yyyy-MM-dd').'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-6 create-one-more-tour" data-dismiss="modal">'.Yii::t('app', 'Close').'</button>
                                        <button type="button" class="btn btn-primary col-xs-6" data-dismiss="modal">'.Yii::t('app', 'Create same tour').'</button>
                                      </div>'
                    ];

                    //event: user tour create
                    $eventHandler = new EventHandler();
                    $mailerEvent = new MailerEvent();
                    $mailerEvent->tour = $userTour;
                    $eventHandler->on(EventHandler::EVENT_NEW_USER_TOUR, [$mailerEvent, 'userCreateTour']);
                    $eventHandler->newUserTour();
                }else{
                    $response = [
                        'status' => 'error',
                        'errors' => $model->getErrors(),
                        'model' => $model
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

    public function actionGetUserTourList(){
        $model = new CreateTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                if(Yii::$app->user->identity->multiple_region_paid == 1) {
                    $cities = \app\models\City::find()->where(['country_id' => Yii::$app->user->identity->city->country->country_id])->all();
                    $cities_arr = [];
                    foreach($cities as $city){
                        $cities_arr[] = $city->city_id;
                    }
                    $tours = UserTour::find()->where([
                        'country_id' => $model->destination,
                        'resort_id' => $model->resort,
                        'region_owner_id' => $cities_arr
                    ])->all();
                }else {
                    $tours = UserTour::find()->where([
                        'country_id' => $model->destination,
                        'resort_id' => $model->resort,
                        'region_owner_id' => Yii::$app->user->identity->region_id
                    ])->all();
                }
                if($tours) {
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
                $country = new Country();
                $departCityThereDropdown = $departCity->regionDropdown();
                $dropdownDestination = [$userTour->country_id => $userTour->country->name];
                $dropdownDepartCountries = $country->destinationDropdown(Yii::$app->params['depart_countries']);
                $dropdownResort = [$userTour->resort_id => $userTour->city->name];
                $createTourForm->user_id = $userTour->owner_id;
                $createTourForm->from_tour_id = $userTour->id;
                $createTourForm->flight_included = $userTour->flight_included;
                $createTourForm->adult_amount = $userTour->adult_amount;
                $createTourForm->room_count = $userTour->room_count;
                $createTourForm->children_under_12_amount = $userTour->children_under_12_amount;
                $createTourForm->children_under_2_amount = $userTour->children_under_2_amount;
                $destinationCityDropdown = $city->destinationCityDropdown(Yii::$app->params['depart_countries']);

                //get hotels list
                if(!empty($userTour->hotel_id)){
                    $createTourForm->hotel_id = $userTour->hotel_id;
                    $createTourForm->hotel = $userTour->hotel->name;
                    $createTourForm->stars = $userTour->hotel->star_id;
                    $hotels = Hotel::find()->where([
                        'country_id' => $userTour->country_id,
                        'hotel_id' => $userTour->hotel_id
                    ])->all();
                    $dropdownHotel = [$userTour->hotel_id => $userTour->hotel->name];
                }else{
                    $stars = [];
                    foreach($userTour->categories as $star){
                        $stars[] = $star->star_id;
                    }
                    $hotels = Hotel::find()->where([
                        'country_id' => $userTour->country_id,
                        'resort_id' => $userTour->resort_id,
                        'star_id' => $stars
                    ])->all();
                    $createTourForm->stars = $stars;
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
                        'destinationCityDropdown' => $destinationCityDropdown,
                        'dropdownDepartCountries' => $dropdownDepartCountries
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
            if(Yii::$app->user->identity->multiple_region_paid == 1) {
                $cities = \app\models\DepartCity::find()->where(['country_id' => Yii::$app->user->identity->city->country->country_id])->all();
                $cities_arr = [];
                foreach($cities as $city){
                    $cities_arr[] = $city->city_id;
                }
                $userTours = UserTour::find()->where([
                    'region_owner_id' => $cities_arr
                ])->orderBy('created_at DESC')->all();
            }else {
                $userTours = UserTour::find()->where([
                    'region_owner_id' => Yii::$app->user->identity->region_id
                ])->select('id, country_id, resort_id, hotel_id, created_at, adult_amount, children_under_12_amount, children_under_2_amount')->orderBy('created_at DESC')->all();
            }//if ($userTours) {
                $createTourForm = new CreateTourForm();
                $response = [
                    'status' => 'ok',
                    'html' => $this->renderAjax('partial/user-tour-list', ['tours' => $userTours]),
                    'form' => $this->renderAjax('partial/manager-tour-response-form-empty', [
                        'CreateTourForm' => $createTourForm
                    ]),
                    'tab_name' => Yii::t('app', 'Tour from users')
                ];
            //}
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
                    $hotel = Hotel::find()->where(['hotel_id' => $model->hotel_id[0]])->one();
                    $tourResponse->hotel_star = $hotel->star_id;
                }else{
                    $tourResponse->hotel_id = null;
                    $tourResponse->hotel_star = null;
                }
                $tourResponse->nutrition = $model->nutrition;
                $tourResponse->room_type = $model->room_type;
                $tourResponse->location = $model->location;
                $tourResponse->hotel_type = $model->hotel_type;
                $tourResponse->beach_line = $model->beach_line;
                $tourResponse->room_view = $model->room_view;
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
                $tourResponse->deadline = $model->deadline;
                $tourResponse->medicine_insurance = $model->medicine_insurance;
                $tourResponse->charge_manager = $model->charge_manager;
                $tourResponse->tour_cost = $model->tour_cost;
                $tourResponse->user_id = $model->user_id;
                $tourResponse->from_tour_id = $model->from_tour_id;
                $tourResponse->manager_id = Yii::$app->user->identity->getId();
                $tourResponse->region_manager_id = Yii::$app->user->identity->region_id;
                if($tourResponse->save()) {
                    $timeCycle = TimeCycles::find()->where(['is not', 'id', null])->one();
                    $tourResponseLifeInSec = $timeCycle->tour_response_life*3600;
                    $response = [
                        'status' => 'ok',
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Just now you have been created your response to tourist. Warning! All responses are actually only to : ").Yii::$app->formatter->asDate((time()+$tourResponseLifeInSec),'yyyy-MM-dd').'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-6 create-one-more-manager-response" data-dismiss="modal">'.Yii::t('app', 'Create new one').'</button>
                                        <button type="button" class="btn btn-primary col-xs-6 to-request-list">'.Yii::t('app', 'Back to request list').'</button>
                                      </div>',
                        'tour' => $this->renderAjax('partial/user-tour-response', ['tour' => $tourResponse, 'tour_title' => 'offer']),
                        'count' => TourResponse::find()->where([
                            'manager_id' => Yii::$app->user->identity->getId(),
                            'is_hot_tour' => 0
                        ])->count()
                    ];
                    //event: manager response tour create
                    $eventHandler = new EventHandler();
                    $mailerEvent = new MailerEvent();
                    $mailerEvent->tour = $tourResponse;
                    $eventHandler->on(EventHandler::EVENT_MANAGER_TOUR_RESPONSE, [$mailerEvent, 'managerCreateResponseTour']);
                    $eventHandler->managerTourResponse();
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
            $destinationCustomDropdown = $country->destinationDropdown(\Yii::$app->params['depart_countries']);
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
                    'departCountryDropdown' => $departCountryDropdown,
                    'destinationCustomDropdown' => $destinationCustomDropdown
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
                $country = new Country();
                $dropdownDepartCountries = $country->destinationDropdown(Yii::$app->params['depart_countries']);
                $departCityThereDropdown = $departCity->regionDropdown();
                $dropdownDestination = [$userTour->country_id => $userTour->country->name];
                $dropdownResort = [$userTour->resort_id => $userTour->city->name];
                $createTourForm->flight_included = $userTour->flight_included;
                $createTourForm->adult_amount = $userTour->adult_amount;
                $createTourForm->children_under_12_amount = $userTour->children_under_12_amount;
                $createTourForm->children_under_2_amount = $userTour->children_under_2_amount;
                $createTourForm->room_count = $userTour->room_count;
                $createTourForm->user_id = $userTour->owner_id;
                $createTourForm->from_tour_id = $userTour->id;
                $destinationCityDropdown = $city->destinationCityDropdown($userTour->country_id);

                if(!empty($userTour->hotel_id)){
                    $dropdownHotel = [$userTour->hotel_id => $userTour->hotel->name];
                    $createTourForm->hotel = $userTour->hotel->name;
                    $createTourForm->hotel_id = $userTour->hotel_id;
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
                        'destinationCityDropdown' => $destinationCityDropdown,
                        'dropdownDepartCountries' => $dropdownDepartCountries
                    ]),
                    'tab_name' => Yii::t('app', 'Tour from users'),
                    'model' => $createTourForm
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
                if(!empty($model->destination)){
                    $query['country_id'] = $model->destination;
                }
                if(!empty($model->resort)){
                    $query['city_id'] = $model->resort;
                }
                if($model->night_count != 0){
                    $query['night_count'] = $model->night_count;
                }
                if(!empty($model->depart_city)){
                    $query['depart_city_there'] = $model->depart_city;
                }
                if(!empty($model->stars)){
                    $query['hotel_star'] = $model->stars;
                }
                $tourResponses = TourResponse::find()->where([
                    'user_id' => Yii::$app->user->identity->getId()
                ])->andWhere($query)->all();

                if(!empty($tourResponses)) {
                    $response = [
                        'status' => 'ok',
                        'model' => $model,
                        'tours' => $this->renderAjax('partial/tour-response-list', ['tours' => $tourResponses, 'tour_title' => 'offer']),
                        'count' => count($tourResponses),
                        'stars' => $model->stars
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', 'Hotels not found. Please, change search params.'),
                        'count' => 0,
                        'stars' => $model->stars
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
                    $tourResponse->hotel_star = Hotel::find()->where(['hotel_id' => $model->hotel_id[0]])->one()->star_id;
                }else{
                    $tourResponse->hotel_id = null;
                }
                $tourResponse->nutrition = $model->nutrition;
                $tourResponse->room_type = $model->room_type;
                $tourResponse->location = $model->location;
                $tourResponse->hotel_type = $model->hotel_type;
                $tourResponse->beach_line = $model->beach_line;
                $tourResponse->room_view = $model->room_view;
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
                $tourResponse->deadline = $model->deadline;
                $tourResponse->medicine_insurance = $model->medicine_insurance;
                $tourResponse->charge_manager = $model->charge_manager;
                $tourResponse->tour_cost = $model->tour_cost;
                $tourResponse->is_hot_tour = $model->is_hot_tour;
                $tourResponse->manager_id = Yii::$app->user->identity->getId();
                $tourResponse->region_manager_id = Yii::$app->user->identity->region_id;
                if($tourResponse->save()) {
                    $response = [
                        'status' => 'ok',
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Just now you have been created your response to tourist. Warning! This tour are actually only to ").''.date('d.m.Y', strtotime($tourResponse->deadline)).'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-12 create-one-more-hot-tour" data-dismiss="modal">'.Yii::t('app', 'Create one more hot tour').'</button>
                                      </div>',
                        'tour' =>  $this->renderAjax('partial/user-tour-response', ['tour' => $tourResponse, 'tour_title' => 'my-hot-tour']),
                        'count' => TourResponse::find()->where([
                            'manager_id' => Yii::$app->user->identity->getId(),
                            'is_hot_tour' => 1
                        ])->count()
                    ];
                    //event: manager hot tour create
                    $eventHandler = new EventHandler();
                    $mailerEvent = new MailerEvent();
                    $mailerEvent->tour = $tourResponse;
                    $eventHandler->on(EventHandler::EVENT_MANAGER_HOT_TOUR, [$mailerEvent, 'managerCreateHotTour']);
                    $eventHandler->managerHotTour();
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

    public function actionAjaxGetManagerOffersList(){
        $model = new ManagerOffersForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                $query = [];
                if(!empty($model->destination)){
                    $query['country_id'] = $model->destination;
                }
                if(!empty($model->resort)){
                    $query['city_id'] = $model->resort;
                }
                if(!empty($model->hotel_id)){
                    $query['hotel_id'] = $model->hotel_id;
                }
                $managerOffers = TourResponse::find()->where([
                    'manager_id' => Yii::$app->user->identity->getId(),
                    'is_hot_tour' => 0
                ])->andWhere($query)->all();
                if($managerOffers){
                    $response = [
                        'status' => 'ok',
                        'tours' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $managerOffers, 'tour_title' => 'my-offer']),
                        'count' => count($managerOffers)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'tours' => [],
                        'message' => Yii::t('app', "Tour was not found."),
                        'count' => 0,
                        'model' => $model
                    ];
                }
            }else{
                $response = [
                    'status' => 'error',
                    'tours' => [],
                    'message' => Yii::t('app', "Tour was not found."),
                    'count' => 0,
                    'model' => $model
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxGetManagerHotToursList(){
        $model = new ManagerHotTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                $query = [];
                if(!empty($model->destination)){
                    $query['country_id'] = $model->destination;
                }
                if(!empty($model->resort)){
                    $query['city_id'] = $model->resort;
                }
                if(!empty($model->hotel_id)){
                    $query['hotel_id'] = $model->hotel_id;
                }
                $managerOffers = TourResponse::find()->where([
                    'manager_id' => Yii::$app->user->identity->getId(),
                    'is_hot_tour' => 1
                ])->andWhere($query)->all();
                if($managerOffers){
                    $response = [
                        'status' => 'ok',
                        'tours' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $managerOffers, 'tour_title' => 'my-hot-tour']),
                        'count' => count($managerOffers)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'tours' => [],
                        'message' => Yii::t('app', "Tour was not found."),
                        'count' => 0,
                        'model' => $model
                    ];
                }
            }else{
                $response = [
                    'status' => 'error',
                    'tours' => [],
                    'message' => Yii::t('app', "Tour was not found."),
                    'count' => 0,
                    'model' => $model
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxGetUserHotToursList(){
        $model = new UserHotTourForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                $query = [];
                if(!empty($model->destination)){
                    $query['country_id'] = $model->destination;
                }
                if(!empty($model->resort)){
                    $query['city_id'] = $model->resort;
                }
                $userHotTours = TourResponse::find()->where([
                    'region_manager_id' => Yii::$app->user->identity->region_id,
                    'is_hot_tour' => 1
                ])->andWhere($query)->all();
                if($userHotTours){
                    $response = [
                        'status' => 'ok',
                        'tours' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $userHotTours, 'tour_title' => 'user-hot-tour']),
                        'count' => count($userHotTours)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'tours' => [],
                        'message' => Yii::t('app', "Tour was not found."),
                        'count' => 0,
                        'model' => $model
                    ];
                }
            }else{
                $response = [
                    'status' => 'error',
                    'tours' => [],
                    'message' => Yii::t('app', "Tour was not found."),
                    'count' => 0,
                    'model' => $model
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxGetUserFavouritesToursList(){
        $model = new UserFavouriteForm();
        if(Yii::$app->request->isAjax) {
            if($model->load(Yii::$app->request->get())){
                $query = [];
                if(!empty($model->destination)){
                    $query['country_id'] = $model->destination;
                }
                $userFavouritesIds = Yii::$app->user->identity->favourites;
                $favouritesIds = [];
                foreach($userFavouritesIds as $one){
                    $favouritesIds[] = $one->tour_id;
                }
                $userFavouriteTours = TourResponse::find()->where([
                    'id' => $favouritesIds
                ])->andWhere($query)->all();
                if($userFavouriteTours){
                    $response = [
                        'status' => 'ok',
                        'tours' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $userFavouriteTours, 'tour_title' => 'user-favourites']),
                        'count' => count($userFavouriteTours)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'tours' => [],
                        'message' => Yii::t('app', "Tour was not found."),
                        'count' => 0,
                        'model' => $model
                    ];
                }
            }else{
                $response = [
                    'status' => 'error',
                    'tours' => [],
                    'message' => Yii::t('app', "Tour was not found."),
                    'count' => 0,
                    'model' => $model
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAddToFavourite($tour_id){
        if(Yii::$app->request->isAjax) {
            $userFavourite = new UserTourFavourites();
            $userTourFavourite = $userFavourite->isFavourite($tour_id);
            if($userTourFavourite){
                $userFavourite->deleteAll(['tour_id' => $tour_id, 'user_id' => Yii::$app->user->identity->getId()]);
                $response = [
                    'status' => 'ok',
                    'action' => 'delete',
                    'tour_id' => $tour_id,
                    'count' => $userFavourite->find()->where(['user_id' => Yii::$app->user->identity->getId()])->count()
                ];
            }else {
                $userFavourite->tour_id = $tour_id;
                $userFavourite->user_id = Yii::$app->user->identity->getId();
                if($userFavourite->save()) {
                    $userFavouriteTour[] = TourResponse::findOne($tour_id);
                    $response = [
                        'status' => 'ok',
                        'action' => 'add',
                        'tour' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $userFavouriteTour, 'tour_title' => 'user-favourites']),
                        'tour_id' => $tour_id,
                        'count' => $userFavourite->find()->where(['user_id' => Yii::$app->user->identity->getId()])->count()
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app','Error')
                    ];
                }
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    //order tour list
    public function actionAjaxOrderToursList(){
        if(Yii::$app->request->isAjax) {
            $order_by = Yii::$app->request->getQueryParam('order_by', null);
            $ids = Yii::$app->request->getQueryParam('ids', null);
            $type = Yii::$app->request->getQueryParam('type', null);
            if(!is_null($order_by)){
                $query = '';
                switch($order_by){
                    case 'cheap-to-expensive':
                        $query .= 'tour_cost asc';
                        break;
                    case 'expensive-to-cheap':
                        $query .= 'tour_cost desc';
                        break;
                    case 'new-to-old':
                        $query .= 'created_at desc';
                        break;
                    case 'old-to-new':
                        $query .= 'created_at asc';
                        break;
                }
                $tourList = TourResponse::find()->where([
                    'id' => $ids
                ])->orderBy($query)->all();
                $response = [
                    'status' => 'ok',
                    'ids' => Yii::$app->request->get(),
                    'order_by' => $order_by,
                    'tourList' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $tourList, 'tour_title' => $type]),
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'message' => Yii::t('app','Error')
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    //full information about tour
    public function actionAjaxTourFullInfo(){
        $tour_id = Yii::$app->request->getQueryParam('tour_id', null);
        if(!is_null($tour_id)){
            $tour = TourResponse::findOne($tour_id);
            $response = [
                'status' => 'ok',
                'tour' => $this->renderAjax('partial/tour-full-info', ['tour' => $tour]),
                'message' => Yii::t('app', 'Tour was found.')
            ];
        }else{
            $response = [
                'status' => 'error',
                'tour' => '',
                'message' => Yii::t('app', 'Tour was not found.')
            ];
        }
        echo Json::encode($response);
        Yii::$app->end();
    }

    public function actionAjaxGetManagerOffersListById(){
        if(Yii::$app->request->isAjax) {
            $tour_id = Yii::$app->request->getQueryParam('tour_id', null);
            if(!is_null($tour_id)){
                if($tour_id != '') {
                    $tourList = TourResponse::find()->where(['manager_id' => Yii::$app->user->identity->getId(), 'is_hot_tour' => 0, 'id' => $tour_id])->orderBy('created_at DESC')->all();
                }else{
                    $tourList = TourResponse::find()->where(['manager_id' => Yii::$app->user->identity->getId(), 'is_hot_tour' => 0])->orderBy('created_at DESC')->all();
                }
                if($tourList) {
                    $response = [
                        'status' => 'ok',
                        'tours' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $tourList, 'tour_title' => 'my-offer']),
                        'message' => Yii::t('app', 'Tour was found.'),
                        'count' => count($tourList)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'tours' => '',
                        'message' => Yii::t('app', 'Tour was not found.'),
                        'count' => 0
                    ];
                }
            }else{
                $response = [
                    'status' => 'error',
                    'tours' => '',
                    'message' => Yii::t('app', 'Tour was not found.'),
                    'count' => 0
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxGetManagerHotToursListById(){
        if(Yii::$app->request->isAjax) {
            $tour_id = Yii::$app->request->getQueryParam('tour_id', null);
            if(!is_null($tour_id)){
                if($tour_id != '') {
                    $tourList = TourResponse::find()->where(['manager_id' => Yii::$app->user->identity->getId(), 'is_hot_tour' => 1, 'id' => $tour_id])->orderBy('created_at DESC')->all();
                }else{
                    $tourList = TourResponse::find()->where(['manager_id' => Yii::$app->user->identity->getId(), 'is_hot_tour' => 1])->orderBy('created_at DESC')->all();
                }
                if($tourList) {
                    $response = [
                        'status' => 'ok',
                        'tours' => $this->renderAjax('//tour/partial/tour-response-list', ['tours' => $tourList, 'tour_title' => 'my-hot-tour']),
                        'message' => Yii::t('app', 'Tour was found.'),
                        'count' => count($tourList)
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'tours' => '',
                        'message' => Yii::t('app', 'Tour was not found.'),
                        'count' => 0
                    ];
                }
            }else{
                $response = [
                    'status' => 'error',
                    'tours' => '',
                    'message' => Yii::t('app', 'Tour was not found.'),
                    'count' => 0
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionRemoveHotTour(){
        if(Yii::$app->request->isAjax) {
            $tour_id = Yii::$app->request->getQueryParam('tour_id', null);
            if(!is_null($tour_id)){
                if(TourResponse::findOne($tour_id)->delete()) {
                    $response = [
                        'status' => 'ok',
                        'message' => Yii::t('app', 'Tour was found.'),
                        'count' => TourResponse::find()->where([
                            'manager_id' => Yii::$app->user->identity->getId(),
                            'is_hot_tour' => 1
                        ])->count()
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'message' => Yii::t('app', 'Tour was not found.')
                    ];
                }
            }else{
                $response = [
                    'status' => 'error',
                    'message' => Yii::t('app', 'Tour was not found.')
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }
}
