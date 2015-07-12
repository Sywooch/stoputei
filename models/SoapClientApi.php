<?php
namespace app\models;

use Yii;
use yii\base\Exception;

class SoapClientApi
{
    private static $_instance = null;

    private function __construct(){}

    private function __clone(){}

    public static function getInstance(){
        if(is_null(self::$_instance)){
            $auth = [
                "Login" => Yii::$app->params['api']['soap_login'],
                "Password" => Yii::$app->params['api']['soap_password']
            ];
            $exceptions = [];
            $client = new \SoapClient(Yii::$app->params['api']['wsdl'], $exceptions);
            $header = new \SoapHeader(Yii::$app->params['api']['namespace'], 'AuthInfo', $auth, false);

            $client->__setSoapHeaders($header);
            self::$_instance = $client;
        }
        return self::$_instance;
    }

    public static function getCountries(){
        $countries = self::getInstance()->GetCountries();
        return $countries->GetCountriesResult->Country;
    }

    public static function getCities($countryId){
        $city = self::getInstance()->GetCities(
            ["countryId" => $countryId]
        );
        return $city->GetCitiesResult;
    }

    public static function getDepartCities(){
        $depart_cities = self::getInstance()->GetDepartCities();
        return $depart_cities->GetDepartCitiesResult->City;
    }

    public static function getHotels($countryId, $towns = null, $stars = null, $filter = null, $count = -1){
        $hotels = self::getInstance()->GetHotels(
            ["countryId" => $countryId,
                "towns" => $towns,
                "stars" => $stars,
                "filter" => $filter,
                "count" => $count]
        );
        return $hotels->GetHotelsResult;
    }

    public static function getHotelStars($countryId, array $cities = []){
        $hotel_stars = self::getInstance()->GetHotelStars(
            ["countryId" => $countryId,
                "towns" => $cities]
        );
        return $hotel_stars->GetHotelStarsResult;
    }

    public static function getMeals(){
        $meals = self::getInstance()->GetMeals();
        return $meals->GetMealsResult->Meal;
    }

    public static function getHotelInformation($hotelId){
        try{
            $hotel_info = self::getInstance()->GetHotelInformation(
                ["hotelId" => $hotelId]
            );
            return $hotel_info->GetHotelInformationResult;
        } catch (\SoapFault $exception) {
            echo $exception->getMessage();
            return null;
        }
    }

    public static function getHotelFacilities($hotelId){
        try {
            $hotel_info = self::getHotelInformation($hotelId);
            if(!is_object($hotel_info)){
                return [];
            }
            $hotel_facility = $hotel_info->HotelFacilities;
            $facilities = [];
            if(property_exists($hotel_facility,'HotelInfoFacilityGroup')){
                $facilities = $hotel_facility->HotelInfoFacilityGroup;
            }
            return $facilities;
        }catch(Exception $e){
            return [];
        }
    }

    public static function getHotelImages($hotelId){
        $hotel_info = self::getHotelInformation($hotelId);
        if($hotel_info->ImageCount == 0){
            return null;
        }
        return $hotel_info->ImageUrls->string;
    }

    public static function getHotelComments($hotelId){
        $hotel_comments = self::getInstance()->GetHotelComments(
            ["hotelId" => $hotelId]
        );
        return $hotel_comments->GetHotelCommentsResult;
    }
}