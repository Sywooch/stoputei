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
                $userFlight->date_city_to_until = $model->date_city_to_until;
                $userFlight->date_city_from_since = $model->date_city_from_since;
                $userFlight->date_city_from_until = $model->date_city_from_until;
                $userFlight->adult_count_senior_24 = $model->adult_count_senior_24;
                $userFlight->adult_count_under_24 = $model->adult_count_under_24;
                $userFlight->children_under_12_amount = $model->children_under_12_amount;
                $userFlight->children_under_2_amount = $model->children_under_2_amount;
                $userFlight->flight_class = $model->flight_class;
                $userFlight->direct_flight = $model->direct_flight;
                $userFlight->regular_flight = $model->regular_flight;
                $userFlight->owner_id = Yii::$app->user->identity->getId();
                $userFlight->region_owner_id = Yii::$app->user->identity->region_id;
                if($userFlight->save()){
                    $response = [
                        'status' => 'ok',
                        'popup' => '<div>'.Yii::t('app', "Congratulations! Request on flights was submitted successfully.").'</div><div class="modal-footer">
                                        <button type="button" class="btn btn-default col-xs-6" data-dismiss="modal">'.Yii::t('app', 'Create new one request').'</button>
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
                    'errors' => $model->getErrors()
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }
}