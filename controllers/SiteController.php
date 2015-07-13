<?php

namespace app\controllers;

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

class SiteController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'index'],
                'rules' => [
                    [
                        'actions' => ['logout', 'index'],
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

    public function actionIndex()
    {
        switch(Yii::$app->user->identity->role){
            case 1:
                $GetTourForm = new GetTourForm();
                $country = new Country();
                $departCity = new DepartCity();
                $destinationDropdown = $country->destinationDropdown();
                $departCityDropdown = $departCity->regionDropdown();
                $GetTourForm->flight_included = 1;
                return $this->render('index',
                    [
                        'email' => Yii::$app->user->identity->email,
                        'GetTourForm' => $GetTourForm,
                        'destinationDropdown' => $destinationDropdown,
                        'departCityDropdown' => $departCityDropdown
                    ]);
            case 2:
                if((Yii::$app->user->identity->single_region_paid == 1) or (Yii::$app->user->identity->multiple_region_paid == 1)) {
                    $CreateTourForm = new CreateTourForm();
                    $country = new Country();
                    $departCity = new DepartCity();
                    $destinationDropdown = $country->destinationDropdown();
                    $departCityDropdown = $departCity->regionDropdown();
                    $userTours = UserTour::find()->where([
                        'region_owner_id' => Yii::$app->user->identity->region_id
                    ])->all();
                    return $this->render('index_manager_paid',
                        [
                            'email' => Yii::$app->user->identity->email,
                            'CreateTourForm' => $CreateTourForm,
                            'destinationDropdown' => $destinationDropdown,
                            'departCityDropdown' => $departCityDropdown,
                            'userTours' => $userTours
                        ]);
                }else{
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
                    $model->login();
                    return $this->goBack();
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
        $departCity = new DepartCity();
        $dropdown = $departCity->regionDropdown();
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
        Yii::$app->user->logout();

        return $this->goHome();
    }

    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

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
}
