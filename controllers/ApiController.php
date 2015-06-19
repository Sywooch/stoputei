<?php

namespace app\controllers;

use Yii;
use yii\base\Exception;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\SoapClientApi;

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
}
