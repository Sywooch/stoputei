<?php

namespace app\controllers;

use app\models\City;
use Yii;
use yii\web\Controller;
use yii\filters\AccessControl;
use app\models\Country;
use app\models\ProfileEditForm;
use yii\web\User;

class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['index'],
                'rules' => [
                    [
                        'actions' => ['index'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ]
        ];
    }

    public function actionIndex(){
        if(Yii::$app->user->isGuest){
            return $this->goHome();
        }
        $model = new ProfileEditForm();
        $model->email = Yii::$app->user->identity->email;
        $model->role = Yii::$app->user->identity->role;
        if($model->role == 2 or $model->role == 3) {
            $model->company_name = Yii::$app->user->identity->company_name;
            $model->company_city = Yii::$app->user->identity->company_city;
            $model->company_phone = Yii::$app->user->identity->company_phone;
            $model->company_address = Yii::$app->user->identity->company_address;
            $model->company_street = Yii::$app->user->identity->company_street;
            $model->company_underground = Yii::$app->user->identity->company_underground;
            $model->email_about_user_tour = Yii::$app->user->identity->email_about_user_tour;
            $model->email_about_user_flight = Yii::$app->user->identity->email_about_user_flight;
        }elseif($model->role == 1){
            $model->email_about_hot_tour = Yii::$app->user->identity->email_about_hot_tour;
            $model->email_about_tour = Yii::$app->user->identity->email_about_tour;
            $model->email_about_flight = Yii::$app->user->identity->email_about_flight;
        }
        $country = new Country();
        $city = City::find()->where(['city_id' => Yii::$app->user->identity->region_id])->one();
        $model->country = $city->country->country_id;
        $model->region_id = Yii::$app->user->identity->region_id;
        $dropdownCountries = $country->destinationDropdown(Yii::$app->params['depart_countries']);
        $dropdownCities = $city->destinationCityDropdown($city->country->country_id);
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            $user = Yii::$app->user->identity;
            $user->email = $model->email;
            if(!is_null($model->password)){
                $user->setPassword($model->password);
            }
            $user->region_id = $model->region_id;
            if($model->role == 2 or $model->role == 3) {
                $user->company_name = $model->company_name;
                $user->company_city = $model->company_city;
                $user->company_phone = $model->company_phone;
                $user->company_address = $model->company_address;
                $user->company_street = $model->company_street;
                $user->company_underground = $model->company_underground;
                $user->email_about_user_tour = $model->email_about_user_tour;
                $user->email_about_user_flight = $model->email_about_user_flight;
            }
            if($model->role == 1){
                $user->email_about_hot_tour = $model->email_about_hot_tour;
                $user->email_about_tour = $model->email_about_tour;
                $user->email_about_flight = $model->email_about_flight;
            }
            if($user->save()){
                Yii::$app->session->setFlash('success', 'SUCCESS');
                return $this->refresh();
            }else{
                return $this->render('index', [
                    'model' => $model,
                    'dropdownCountries' => $dropdownCountries,
                    'dropdownCities' => $dropdownCities
                ]);
            }
        } else {
            return $this->render('index', [
                'model' => $model,
                'dropdownCountries' => $dropdownCountries,
                'dropdownCities' => $dropdownCities
            ]);
        }
    }
}