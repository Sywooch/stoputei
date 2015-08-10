<?php

namespace app\controllers;

use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\Hotel;

class HotelController extends Controller
{
    public function actionAjaxShowHotelFullInfo(){
        $hotel_id = Yii::$app->request->getQueryParam('hotel_id', null);
        if(!is_null($hotel_id)){
            $hotel = Hotel::find()->where(['hotel_id' => $hotel_id])->one();
            $response = [
                'status' => 'ok',
                'hotel' => $this->renderAjax('partial/hotel-full-info', ['hotel' => $hotel]),
                'message' => Yii::t('app', 'Hotel was found.')
            ];
        }else{
            $response = [
                'status' => 'error',
                'hotel' => '',
                'message' => Yii::t('app', 'Hotel was not found.')
            ];
        }
        echo Json::encode($response);
        Yii::$app->end();
    }
}