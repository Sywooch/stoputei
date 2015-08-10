<?php

namespace app\controllers;

use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\helpers\FileHelper;
use yii\helpers\Url;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\SoapClientApi;
use app\models\Hotel;

class ApiController extends Controller
{

    public function actionIndex()
    {
        $countries = SoapClientApi::getCountries();
        $depart_cities = SoapClientApi::getDepartCities();

        return $this->render('index', [
            'countries' => $countries,
            'depart_cities' => $depart_cities
        ]);
    }

    public function actionImage(){
        $countries = SoapClientApi::getCountries();
        return $this->render('image', [
            'countries' => $countries
        ]);
    }

    public function actionImages(){
        $countries = SoapClientApi::getCountries();
        return $this->render('get_images', [
            'countries' => $countries
        ]);
    }

    public function actionImageList(){
        //$big_images =  FileHelper::findFiles('uploads/hotel_images/big/');
        //$scale_images =  FileHelper::findFiles('uploads/hotel_images/scale/');
        //$small_images =  FileHelper::findFiles('uploads/hotel_images/small/');
        //$countries = SoapClientApi::getCountries();
        return $this->render('get_images');
    }

    public function actionHotels(){
        $hotels = Hotel::find()->where(['country_id' => 149])->limit(30)->all();
        return $this->render('get_hotels', [
            'hotels' => $hotels
        ]);
    }
}
