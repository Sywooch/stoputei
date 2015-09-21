<?php

namespace app\controllers;

use app\components\LiqPay;
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

    public function beforeAction($action) {
        if($this->action->id == 'liqpay-callback') {
            $this->enableCsrfValidation = false;
        }
        return parent::beforeAction($action);
    }

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

    public function actionLiqpayCallback(){
        $signature = Yii::$app->request->post('signature');
        $signature = json_encode($signature);

        $file = 'liqpay-response.txt';
        $fh = fopen($file, 'w') or die("can't open file");
        fwrite($fh, json_encode($signature));
        fclose($fh);

        echo $signature;

    }
}
