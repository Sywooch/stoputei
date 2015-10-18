<?php

namespace app\controllers;

use app\models\EmailPasswordResetForm;
use app\models\Hotel;
use app\models\PageEditForm;
use app\models\Pages;
use app\models\PasswordResetForm;
use Yii;
use yii\filters\AccessControl;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use app\models\DepartCity;
use app\models\RegistrationForm;
use app\models\User;
use app\models\UserTour;
use app\models\GetTourForm;
use app\models\Country;
use app\models\CustomMailer;
use app\models\CreateTourForm;
use app\models\UserFlightForm;
use app\models\UserFlight;
use app\models\ManagerFlightForm;
use app\models\TourResponse;
use app\models\FlightResponse;
use app\models\TourOffersForm;
use app\models\CreateHotTourForm;
use app\models\City;
use app\models\ManagerHotTourForm;
use app\models\ManagerOffersForm;
use app\models\UserFavouriteForm;
use app\models\UserHotTourForm;
use app\models\UserTourFavourites;
use yii\db\Expression;

class SiteController extends Controller
{
    //public $defaultAction = 'welcome';

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index', 'payment'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionWelcome(){
        if(!Yii::$app->user->isGuest){
            return $this->redirect(['/main']);
        }
        return $this->render('welcome');
    }

    public function actionIndex()
    {
        switch(Yii::$app->user->identity->role){
            case 1:
                $GetTourForm = new GetTourForm();
                $UserFlightForm = new UserFlightForm();
                $TourOffersForm = new TourOffersForm();
                $UserHotTourForm = new UserHotTourForm();
                $userFavouriteForm = new UserFavouriteForm();
                $country = new Country();
                $departCity = new DepartCity();
                $city = new City();
                $flightsUserResponse = FlightResponse::find()->where([
                    'user_id' => Yii::$app->user->identity->getId()
                ])->orderBy('created_at DESC')->all();
                $tourUserResponse = TourResponse::find()->where([
                    'user_id' => Yii::$app->user->identity->getId()
                ])->orderBy('created_at DESC')->all();
                $userHotTours = TourResponse::find()->where([
                    'region_manager_id' => Yii::$app->user->identity->region_id,
                    'is_hot_tour' => 1
                ])->orderBy('created_at DESC')->all();
                $userFavouritesIds = Yii::$app->user->identity->favourites;
                $favouritesIds = [];
                foreach($userFavouritesIds as $one){
                    $favouritesIds[] = $one->tour_id;
                }
                $userFavouriteTours = TourResponse::findAll($favouritesIds);
                $destinationDropdown = $country->destinationDropdown();
                $departCountryDropdown = $country->destinationDropdown(\Yii::$app->params['depart_countries']);
                $departCityDropdown = $departCity->regionDropdown();
                $cityDropdown = $city->destinationCityDropdown();
                $GetTourForm->flight_included = 1;

                return $this->render('index',
                    [
                        'email' => Yii::$app->user->identity->email,
                        'GetTourForm' => $GetTourForm,
                        'UserFlightForm' => $UserFlightForm,
                        'TourOffersForm' => $TourOffersForm,
                        'UserHotTourForm' => $UserHotTourForm,
                        'userFavouriteForm' => $userFavouriteForm,
                        'destinationDropdown' => $destinationDropdown,
                        'departCityDropdown' => $departCityDropdown,
                        'cityDropdown' => $cityDropdown,
                        'flightsUserResponse' => $flightsUserResponse,
                        'tourUserResponse' => $tourUserResponse,
                        'departCountryDropdown' => $departCountryDropdown,
                        'userHotTours' => $userHotTours,
                        'userFavouriteTours' => $userFavouriteTours
                    ]);
            case 2:
            case 3:
                if(Yii::$app->user->identity->multiple_region_paid == 1) {
                    $cities = \app\models\City::find()->where(['country_id' => Yii::$app->user->identity->city->country->country_id])->all();
                    $cities_arr = [];
                    foreach($cities as $city){
                        $cities_arr[] = $city->city_id;
                    }
                    $CreateTourForm = new CreateTourForm();
                    $CreateHotTourForm = new CreateHotTourForm();
                    $ManagerFlightForm = new ManagerFlightForm();
                    $ManagerOffersForm = new ManagerOffersForm();
                    $ManagerHotTourForm = new ManagerHotTourForm();
                    $country = new Country();
                    $departCity = new DepartCity();
                    $destinationDropdown = $country->destinationDropdown();
                    $departCityDropdown = $departCity->regionDropdown();
                    $departCountryDropdown = $country->destinationDropdown(\Yii::$app->params['depart_countries']);
                    $userTours = UserTour::find()->where([
                        'region_owner_id' => $cities_arr
                    ])->orderBy('created_at DESC')->all();
                    $userFlights = UserFlight::find()->where([
                        'region_owner_id' => $cities_arr
                    ])->orderBy('created_at DESC')->all();
                    $myOffers = TourResponse::find()->where([
                        'manager_id' => Yii::$app->user->identity->getId(),
                        'is_hot_tour' => 0
                    ])->orderBy('created_at DESC')->all();
                    $myHotTours = TourResponse::find()->where([
                        'manager_id' => Yii::$app->user->identity->getId(),
                        'is_hot_tour' => 1
                    ])->orderBy('created_at DESC')->all();
                    return $this->render('index_manager_paid',
                        [
                            'email' => Yii::$app->user->identity->email,
                            'CreateTourForm' => $CreateTourForm,
                            'CreateHotTourForm' => $CreateHotTourForm,
                            'ManagerFlightForm' => $ManagerFlightForm,
                            'ManagerOffersForm' => $ManagerOffersForm,
                            'ManagerHotTourForm' => $ManagerHotTourForm,
                            'destinationDropdown' => $destinationDropdown,
                            'departCityDropdown' => $departCityDropdown,
                            'userTours' => $userTours,
                            'userFlights' => $userFlights,
                            'departCountryDropdown' => $departCountryDropdown,
                            'myOffers' => $myOffers,
                            'myHotTours' => $myHotTours
                        ]);
                }elseif(Yii::$app->user->identity->single_region_paid == 1) {
                    $CreateTourForm = new CreateTourForm();
                    $CreateHotTourForm = new CreateHotTourForm();
                    $ManagerFlightForm = new ManagerFlightForm();
                    $ManagerOffersForm = new ManagerOffersForm();
                    $ManagerHotTourForm = new ManagerHotTourForm();
                    $country = new Country();
                    $departCity = new DepartCity();
                    $destinationDropdown = $country->destinationDropdown();
                    $departCityDropdown = $departCity->regionDropdown();
                    $departCountryDropdown = $country->destinationDropdown(\Yii::$app->params['depart_countries']);
                    $userTours = UserTour::find()->where([
                        'region_owner_id' => Yii::$app->user->identity->region_id
                    ])->orderBy('created_at DESC')->all();
                    $userFlights = UserFlight::find()->where([
                        'region_owner_id' => Yii::$app->user->identity->region_id
                    ])->orderBy('created_at DESC')->all();
                    $myOffers = TourResponse::find()->where([
                        'manager_id' => Yii::$app->user->identity->getId(),
                        'is_hot_tour' => 0
                    ])->orderBy('created_at DESC')->all();
                    $myHotTours = TourResponse::find()->where([
                        'manager_id' => Yii::$app->user->identity->getId(),
                        'is_hot_tour' => 1
                    ])->orderBy('created_at DESC')->all();
                    return $this->render('index_manager_paid',
                        [
                            'email' => Yii::$app->user->identity->email,
                            'CreateTourForm' => $CreateTourForm,
                            'CreateHotTourForm' => $CreateHotTourForm,
                            'ManagerFlightForm' => $ManagerFlightForm,
                            'ManagerOffersForm' => $ManagerOffersForm,
                            'ManagerHotTourForm' => $ManagerHotTourForm,
                            'destinationDropdown' => $destinationDropdown,
                            'departCityDropdown' => $departCityDropdown,
                            'userTours' => $userTours,
                            'userFlights' => $userFlights,
                            'departCountryDropdown' => $departCountryDropdown,
                            'myOffers' => $myOffers,
                            'myHotTours' => $myHotTours
                        ]);
                }else {
                    return $this->render('index_manager',
                        ['email' => Yii::$app->user->identity->email]);
                }

        }
    }

    public function actionLogin()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $user = new User();
        if ($model->load(Yii::$app->request->post()) and $model->validate()) {
            if($user->getVerifyCode($model->email)) {
                if($user->isApproved($model->email)){
                    $userCurrent = $user->findByEmail($model->email);
                    if($userCurrent->active == 0 or $userCurrent->active == 1) {
                        $userCurrent->updated_at = new Expression('NOW()');
                        $userCurrent->active = 0;
                        $userCurrent->save();
                        $model->login();
                        return $this->redirect(['/site/index']);
                    }else{
                        return $this->render('login', [
                            'model' => $model,
                            'another_device' => true
                        ]);
                    }
                }else{
                    return $this->render('login', [
                        'model' => $model,
                        'not_approved' => true
                    ]);
                }
            }else{
                return $this->render('login', [
                    'model' => $model,
                    'verify_code' => true
                ]);
            }
        } else {
            return $this->render('login', [
                'model' => $model
            ]);
        }
    }

    public function actionRegistration()
    {
        if (!\Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new RegistrationForm();
        $model->role = 1;
        $country = new Country();
        $dropdown = $country->destinationDropdown([16, 53, 62, 64, 66, 79, 150, 121, 124]);
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            $user = new User();
            $user->email = $model->email;
            $user->setPassword($model->password);
            $user->region_id = $model->region_id;
            $user->role = $model->role;
            $user->company_name = $model->company_name;
            $user->company_city = $model->company_city;
            $user->company_phone = $model->company_phone;
            $user->company_address = $model->company_address;
            $user->company_street = $model->company_street;
            $user->company_underground = $model->company_underground;
            $user->setVerifyCode();
            if($user->save()) {
                CustomMailer::sendSingleMail('verify', 'Verify you account on '.Yii::$app->params['application_name'], $user->email, null, ['email' => $user->email, 'token' => $user->verify]);
                return $this->redirect(['site/registration-success']);
            }
        } else {
            return $this->render('registration', [
                'model' => $model,
                'dropdown' => $dropdown
            ]);
        }
    }

    public function actionGetCityDropdown(){
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

    public function actionRegistrationSuccess(){
        return $this->render('registration_success');
    }

    public function actionVerify($email, $token){
        $user = new User();
        if($user->verify($email, $token)){
            return $this->redirect(['site/login', 'verify_success' => true]);
        }
    }

    public function actionLogout()
    {
        $userCurrent = User::findOne(Yii::$app->user->identity->getId());
        $userCurrent->active = 0;
        $userCurrent->save();
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            Yii::$app->session->setFlash('contactFormSubmitted');
            CustomMailer::sendContactForm('contact', Yii::t('app', 'New Letter from contact form') , null, $model->email, ['email' => $model->email, 'name' => $model->name, 'subject' => $model->subject, 'body' => $model->body]);
            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionAboutEdit()
    {
        if(Yii::$app->user->identity->role != 3){
            throw new \yii\web\HttpException(400);
        }
        $pageEditForm = new PageEditForm();
        $page = Pages::find()->where(['name' => 'about'])->one();
        $pageEditForm->title = $page->title;
        $pageEditForm->body = $page->body;
        if ($pageEditForm->load(Yii::$app->request->post()) and $pageEditForm->validate()){
            $page->title = $pageEditForm->title;
            $page->body = $pageEditForm->body;
            if($page->save()){
                Yii::$app->session->setFlash('successAbout', 'SUCCESS');
                return $this->redirect(['/site/about']);
            }else{
                return $this->render('about-edit', [
                    'model' => $pageEditForm
                ]);
            }
        }else {
            return $this->render('about-edit', [
                'model' => $pageEditForm
            ]);
        }
    }

    public function actionFaq()
    {
        return $this->render('faq');
    }

    public function actionFaqEdit()
    {
        if(Yii::$app->user->identity->role != 3){
            throw new \yii\web\HttpException(400);
        }
        $pageEditForm = new PageEditForm();
        $page = Pages::find()->where(['name' => 'faq'])->one();
        $pageEditForm->title = $page->title;
        $pageEditForm->body = $page->body;
        if ($pageEditForm->load(Yii::$app->request->post()) and $pageEditForm->validate()){
            $page->title = $pageEditForm->title;
            $page->body = $pageEditForm->body;
            if($page->save()){
                Yii::$app->session->setFlash('successFAQ', 'SUCCESS');
                return $this->redirect(['/site/faq']);
            }else{
                return $this->render('faq-edit', [
                    'model' => $pageEditForm
                ]);
            }
        }else {
            return $this->render('faq-edit', [
                'model' => $pageEditForm
            ]);
        }
    }

    public function actionPayment(){
        return $this->render('payment');
    }

    public function actionPasswordReset(){
        $token = Yii::$app->request->getQueryParam('token', null);
        $resetPasswordForm = new PasswordResetForm();
        if(!is_null($token)) {
            $resetPasswordForm->token = $token;
            if ($resetPasswordForm->load(Yii::$app->request->post()) && $resetPasswordForm->validate()) {
                if($user = User::findByPasswordResetToken($resetPasswordForm->token)) {
                    $user->setPassword($resetPasswordForm->password);
                    $user->reset_password_token = null;
                    $user->save();
                    Yii::$app->session->setFlash('resetPassword', 'SUCCESS');
                    return $this->redirect(['/site/login']);
                }else{
                    return $this->render('password-reset', [
                        'model' => $resetPasswordForm,
                        'token' => 'not_exists'
                    ]);
                }
            } else {
                return $this->render('password-reset', [
                    'model' => $resetPasswordForm
                ]);
            }
        }else{
            return $this->render('password-reset', [
                'model' => $resetPasswordForm,
                'token' => 'not_exists'
            ]);
        }
    }

    public function actionEmailConfirmForPassword(){
        $emailResetPasswordForm = new EmailPasswordResetForm();
        if($emailResetPasswordForm->load(Yii::$app->request->post()) && $emailResetPasswordForm->validate()){
            $token = md5(uniqid().''.$emailResetPasswordForm->email.''.Yii::$app->params['hash']);
            $user = User::findByEmail($emailResetPasswordForm->email);
            $user->reset_password_token = $token;
            if($user->save()) {
                CustomMailer::resetPassword($emailResetPasswordForm->email, null, ['token' => $token]);
                return $this->render('email-password-reset', [
                    'model' => $emailResetPasswordForm,
                    'success' => true
                ]);
            }else{
                return $this->render('email-password-reset', [
                    'model' => $emailResetPasswordForm
                ]);
            }
        }else {
            return $this->render('email-password-reset', [
                'model' => $emailResetPasswordForm
            ]);
        }
    }
}
