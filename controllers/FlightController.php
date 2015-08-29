<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\UserFlightForm;
use app\models\UserFlight;
use app\models\FlightResponse;
use app\models\ManagerFlightForm;
use app\models\DepartCity;
use app\models\Country;

class FlightController extends Controller
{
    public function actionSubmitUserFlight()
    {
        $model = new UserFlightForm();
        if (Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                $userFlight = new UserFlight();
                $userFlight->country_id = $model->destination;
                $userFlight->city_id = $model->resort;
                $userFlight->way_ticket = $model->way_ticket;
                $userFlight->depart_city_id = $model->depart_city;
                $userFlight->date_city_to_since = $model->date_city_to_since;
                $userFlight->exactly_date_to_since = $model->exactly_date_to_since;
                $userFlight->date_city_from_since = $model->date_city_from_since;
                $userFlight->exactly_date_from_since = $model->exactly_date_from_since;
                $userFlight->adult_count_senior_24 = $model->adult_count_senior_24;
                $userFlight->adult_count_under_24 = $model->adult_count_under_24;
                $userFlight->children_under_12_amount = $model->children_under_12_amount;
                $userFlight->children_under_2_amount = $model->children_under_2_amount;
                $userFlight->flight_class = $model->flight_class;
                $userFlight->regular_flight = $model->regular_flight;
                $userFlight->owner_id = Yii::$app->user->identity->getId();
                $userFlight->region_owner_id = Yii::$app->user->identity->region_id;
                if($userFlight->save()){
                    $response = [
                        'status' => 'ok',
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Request on flights was submitted successfully.").'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-6 create-one-more-flight" data-dismiss="modal">'.Yii::t('app', 'Create new one request').'</button>
                                        <button type="button" class="btn btn-primary col-xs-6 to-request-user-flight-list" data-dismiss="modal">'.Yii::t('app', 'Back to request list').'</button>
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
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionGetUserFlightFullInfo(){
        if(Yii::$app->request->isAjax) {
            $user_flight_id = Yii::$app->request->getQueryParam('user_flight_id', null);
            if(!is_null($user_flight_id)){
                $userFlight = UserFlight::findOne($user_flight_id);
                $ManagerFlightForm = new ManagerFlightForm();
                $departCity = new DepartCity();
                $country = new Country();
                $dropdownDepartCountry = $country->destinationDropdown();
                $departCountryDropdown = $country->destinationDropdown(Yii::$app->params['depart_countries']);
                $departCityDropdown = $departCity->regionDropdown();
                $dropdownDestination = [$userFlight->country_id => $userFlight->country->name];
                $dropdownResort = [$userFlight->city_id => $userFlight->city->name];
                $ManagerFlightForm->user_id = $userFlight->owner_id;
                $ManagerFlightForm->from_flight_id = $userFlight->id;
                $ManagerFlightForm->voyage_is_direct_to = 1;
                $ManagerFlightForm->voyage_is_direct_from = 1;
                $ManagerFlightForm->way_ticket = $userFlight->way_ticket;
                $ManagerFlightForm->adult_count_under_24 = $userFlight->adult_count_under_24;
                $ManagerFlightForm->adult_count_senior_24 = $userFlight->adult_count_senior_24;
                $ManagerFlightForm->children_under_12_amount = $userFlight->children_under_12_amount;
                $ManagerFlightForm->children_under_2_amount = $userFlight->children_under_2_amount;
                if($userFlight->flight_class == 0) {
                    $ManagerFlightForm->flight_class = [1, 2];
                }else{
                    $ManagerFlightForm->flight_class = $userFlight->flight_class;
                }
                $country = Country::findOne($userFlight->country_id);
                $cities = $country->cities;
                $list = [];
                foreach ($cities as $key => $city) {
                    $list[$city->city_id] = $city->name;
                }

                $response = [
                    'status' => 'ok',
                    'html' => $this->renderAjax('partial/user-flight-full-info', ['flight' => $userFlight]),
                    'flight' => $this->renderAjax('partial/flight', ['flight' => $userFlight]),
                    'form' => $this->renderAjax('partial/manager-flight-response-form', [
                        'ManagerFlightForm' => $ManagerFlightForm,
                        'dropdownDestination' => $dropdownDestination,
                        'dropdownResort' => $dropdownResort,
                        'departCityDropdown' => $departCityDropdown,
                        'dropdownDepartCityFrom' => $list,
                        'dropdownDepartCountry' => $dropdownDepartCountry,
                        'departCountryDropdown' => $departCountryDropdown
                    ]),
                    'tab_name' => Yii::t('app', 'Creating flight'),
                    'checked' => Yii::t('app', 'Checked'),
                    'unchecked' => Yii::t('app', 'More')
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'html' => '',
                    'message' => Yii::t('app', "Flight was not found.")
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionCreateFlightManager(){
        $model = new ManagerFlightForm();
        if(Yii::$app->request->isAjax) {
            if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                $managerFlight = new FlightResponse();
                $managerFlight->country_id = $model->destination;
                $managerFlight->city_id = $model->resort;
                $managerFlight->way_ticket = $model->way_ticket;
                $managerFlight->depart_city_to_id = $model->depart_city_to;
                $managerFlight->depart_city_from_id = $model->depart_city_from;
                $managerFlight->voyage_is_direct_to = $model->voyage_is_direct_to;
                $managerFlight->voyage_is_direct_from = $model->voyage_is_direct_from;
                $managerFlight->voyage_direct_to_id = $model->voyage_direct_to;
                $managerFlight->voyage_direct_from_id = $model->voyage_direct_from;
                $managerFlight->date_city_to = $model->date_city_to;
                $managerFlight->date_city_from = $model->date_city_from;
                $managerFlight->date_docking_to_hours = $model->date_docking_to_hours;
                $managerFlight->date_docking_to_minutes = $model->date_docking_to_minutes;
                $managerFlight->date_docking_from_hours = $model->date_docking_from_hours;
                $managerFlight->date_docking_from_minutes = $model->date_docking_from_minutes;
                $managerFlight->tickets_exist = $model->tickets_exist;
                $managerFlight->adult_count_senior_24 = $model->adult_count_senior_24;
                $managerFlight->adult_count_under_24 = $model->adult_count_under_24;
                $managerFlight->children_under_12_amount = $model->children_under_12_amount;
                $managerFlight->children_under_2_amount = $model->children_under_2_amount;
                $managerFlight->regular_flight = $model->regular_flight;
                $managerFlight->flight_class = $model->flight_class;
                $managerFlight->user_id = $model->user_id;
                $managerFlight->from_flight_id = $model->from_flight_id;
                $managerFlight->flight_cost = $model->flight_cost;
                $managerFlight->manager_id = Yii::$app->user->identity->getId();
                if($managerFlight->save()){
                    $response = [
                        'status' => 'ok',
                        'model' => $model,
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Just now you have been created your response to tourist\s flight. Warning! All responses are actually only 2 days.").'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-6 create-one-more-flight-response" data-dismiss="modal">'.Yii::t('app', 'Create new one').'</button>
                                        <button type="button" class="btn btn-primary col-xs-6 to-request-flight-list-from-modal">'.Yii::t('app', 'Back to request list').'</button>
                                      </div>'
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'errors' => $model->getErrors(),
                        'message' => Yii::t('app', "Flight was not created.")
                    ];
                }
                echo Json::encode($response);
                Yii::$app->end();
            }else{
                $response = [
                    'status' => 'error',
                    'errors' => $model->getErrors(),
                    'message' => Yii::t('app', "Flight was not created.")
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxGetEmptyFlightForm(){
        if(Yii::$app->request->isAjax) {
            $UserFlightForm = new UserFlightForm();
            $country = new Country();
            $departCity = new DepartCity();
            $destinationDropdown = $country->destinationDropdown();
            $departCountryDropdown = $country->destinationDropdown(Yii::$app->params['depart_countries']);
            $departCityDropdown = $departCity->regionDropdown();
            $response = [
                    'status' => 'ok',
                    'form' => $this->renderAjax('partial/user-flight-request-form', [
                    'destinationDropdown' => $destinationDropdown,
                    'UserFlightForm' => $UserFlightForm,
                    'departCityDropdown' => $departCityDropdown,
                    'departCountryDropdown' => $departCountryDropdown
                ])
            ];
            echo Json::encode($response);
            Yii::$app->end();
        }
    }


    public function actionCloseFlightFullInfo(){
        if(Yii::$app->request->isAjax) {
            $userFlights = UserFlight::find()->where([
                'region_owner_id' => Yii::$app->user->identity->region_id
            ])->all();
            $response = [
                    'status' => 'ok',
                    'form' => $this->renderAjax('partial/manager-flight-response-form-empty'),
                    'html' => $this->renderAjax('partial/user-flight-list', ['flights' => $userFlights]),
                    'tab_name' => Yii::t('app', 'Flights'),
                ];
            echo Json::encode($response);
            Yii::$app->end();
        }
    }

    public function actionAjaxCreateOneMoreManagerFlightResponse(){
        if(Yii::$app->request->isAjax) {
            $ManagerFlightForm = new ManagerFlightForm();
            if($ManagerFlightForm->load(Yii::$app->request->get())){
                $userFlight = UserFlight::findOne($ManagerFlightForm->from_flight_id);
                $ManagerFlightForm = new ManagerFlightForm();
                $departCity = new DepartCity();
                $country = new Country();
                $departCityDropdown = $departCity->regionDropdown();
                $dropdownDestination = [$userFlight->country_id => $userFlight->country->name];
                $dropdownResort = [$userFlight->city_id => $userFlight->city->name];
                $ManagerFlightForm->way_ticket = $userFlight->way_ticket;

                $departCountryDropdown = $country->destinationDropdown(Yii::$app->params['depart_countries']);

                $response = [
                    'status' => 'ok',
                    'form' => $this->renderAjax('partial/manager-flight-response-form', [
                        'ManagerFlightForm' => $ManagerFlightForm,
                        'dropdownDestination' => $dropdownDestination,
                        'dropdownResort' => $dropdownResort,
                        'dropdownDepartCityFrom' => $departCityDropdown,
                        'departCityDropdown' => $departCityDropdown,
                        'departCountryDropdown' => $departCountryDropdown,
                        'dropdownDepartCountry' => $departCountryDropdown
                    ]),
                    'tab_name' => Yii::t('app', 'Creating flight')
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

    public function actionAjaxFilterFlightList()
    {
        $UserFlightForm = new UserFlightForm();
        if (Yii::$app->request->isAjax) {
            if($UserFlightForm->load(Yii::$app->request->get())){
                $query = [];
                if(!empty($UserFlightForm->destination)){
                    $query['country_id'] = $UserFlightForm->destination;
                }
                if(!empty($UserFlightForm->resort)){
                    $query['city_id'] = $UserFlightForm->resort;
                }
                if(!empty($UserFlightForm->depart_city)){
                    $query['depart_city_to_id'] = $UserFlightForm->depart_city;
                }
                /*if(!empty($UserFlightForm->date_city_to_since)){
                    $query['date_city_to'] = $UserFlightForm->date_city_to_since;
                }
                if(!empty($UserFlightForm->date_city_to_until)){
                    $query['date_city_from'] = $UserFlightForm->date_city_to_until;
                }*/
                $userFlightList = FlightResponse::find()->where([
                    'user_id' => Yii::$app->user->identity->getId()
                ])->andWhere($query)->all();
                if($userFlightList){
                    $response = [
                        'status' => 'ok',
                        'list' => $this->renderAjax('partial/user-flight-response-list', ['flights' => $userFlightList]),
                        'count' => count($userFlightList),
                        'message' => '',
                        'model' => $UserFlightForm
                    ];
                }else{
                    $response = [
                        'status' => 'error',
                        'list' => '',
                        'count' => 0,
                        'message' => Yii::t('app', "Flights not found. Please, change search params."),
                        'model' => $UserFlightForm
                    ];
                }
                echo Json::encode($response);
                Yii::$app->end();
            }
        }
    }

    //order flights list USER
    public function actionAjaxOrderFlightsListUser(){
        if(Yii::$app->request->isAjax) {
            $order_by = Yii::$app->request->getQueryParam('order_by', null);
            $ids = Yii::$app->request->getQueryParam('ids', null);
            if(!is_null($order_by)){
                $query = '';
                switch($order_by){
                    case 'cheap-to-expensive':
                        $query .= 'flight_cost asc';
                        break;
                    case 'expensive-to-cheap':
                        $query .= 'flight_cost desc';
                        break;
                    case 'new-to-old':
                        $query .= 'created_at desc';
                        break;
                    case 'old-to-new':
                        $query .= 'created_at asc';
                        break;
                }
                $flightList = FlightResponse::find()->where([
                    'id' => $ids
                ])->orderBy($query)->all();
                $response = [
                    'status' => 'ok',
                    'ids' => Yii::$app->request->get(),
                    'order_by' => $order_by,
                    'tourList' => $this->renderAjax('//flight/partial/user-flight-response-list', ['flights' => $flightList]),
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

    //order flights list MANAGER
    public function actionAjaxOrderFlightsListManager(){
        if(Yii::$app->request->isAjax) {
            $order_by = Yii::$app->request->getQueryParam('order_by', null);
            $ids = Yii::$app->request->getQueryParam('ids', null);
            if(!is_null($order_by)){
                $query = '';
                switch($order_by){
                    case 'new-to-old':
                        $query .= 'created_at desc';
                        break;
                    case 'old-to-new':
                        $query .= 'created_at asc';
                        break;
                    default:
                        $query .= 'created_at asc';
                        break;
                }
                $flightList = UserFlight::find()->where([
                    'id' => $ids
                ])->orderBy($query)->all();
                $response = [
                    'status' => 'ok',
                    'ids' => Yii::$app->request->get(),
                    'order_by' => $order_by,
                    'tourList' => $this->renderAjax('//flight/partial/user-flight-list', ['flights' => $flightList]),
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

    public function actionAjaxShowFlightFullInfoUser(){
        if(Yii::$app->request->isAjax) {
            $id = Yii::$app->request->getQueryParam('id', null);
            if(!is_null($id)){
                $flight = FlightResponse::findOne($id);
                $response = [
                    'status' => 'ok',
                    'flight' => $this->renderAjax('partial/flight-full-info-user', ['flight' => $flight]),
                    'message' => Yii::t('app', 'Flight was found.')
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'flight' => '',
                    'message' => Yii::t('app', 'Flight was not found.')
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }
}