<?php

namespace app\controllers;

use app\models\ManagerStatisticsTourForm;
use Yii;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use app\models\TourResponse;
use app\models\UserTour;

class StatisticController extends Controller
{
    public function actionGetManagerTourStatistic(){
        if(Yii::$app->request->isAjax) {
            $model = new ManagerStatisticsTourForm();
            if($model->load(Yii::$app->request->get())){

                //period for user's request
                if($model->request_tour_count != 0) {
                    $period_request = time() - $model->request_tour_count;
                }else{
                    $period_request = 0;
                }
                $query_request = 'created_at >= '.$period_request;

                //period for manager's response
                if($model->response_tour_count != 0) {
                    $period_response = time() - $model->response_tour_count;
                }else{
                    $period_response = 0;
                }
                $query_response = 'created_at >= '.$period_response;

                //period for manager's hot tour
                if($model->hot_tour_count != 0) {
                    $period_hot_tour = time() - $model->hot_tour_count;
                }else{
                    $period_hot_tour = 0;
                }
                $query_hot_tour = 'created_at >= '.$period_hot_tour;

                $tour_count_all_destination = UserTour::find()->where([
                    'region_owner_id' => Yii::$app->user->identity->region_id,
                    'country_id' => $model->country_id
                ])->count();

                $tour_count_request = UserTour::find()->where([
                    'region_owner_id' => Yii::$app->user->identity->region_id,
                    'country_id' => $model->country_id
                ])->andWhere($query_request)->count();

                $tour_count_response = TourResponse::find()->where([
                    'manager_id' => Yii::$app->user->identity->getId(),
                    'country_id' => $model->country_id,
                    'is_hot_tour' => 0
                ])->andWhere($query_response)->count();

                $tour_count_hot_tour = TourResponse::find()->where([
                    'manager_id' => Yii::$app->user->identity->getId(),
                    'country_id' => $model->country_id,
                    'is_hot_tour' => 1
                ])->andWhere($query_hot_tour)->count();

                $response = [
                    'status' => 'ok',
                    'message' => 'Tours was found',
                    'count_all' => $tour_count_all_destination,
                    'count_requests' => $tour_count_request,
                    'count_responses' => $tour_count_response,
                    'count_hot_tours' => $tour_count_hot_tour,
                ];
            }else{
                $response = [
                    'status' => 'error',
                    'message' => 'Request data is empty222',
                    'count' => 0
                ];
            }
            echo Json::encode($response);
            Yii::$app->end();
        }
    }
}