<?php

namespace app\modules\admin\controllers;

use app\models\TourResponse;
use app\models\User;
use app\models\UserSearch;
use app\models\UserTour;
use app\models\UserTourSearch;
use yii\web\Controller;
use yii\data\ActiveDataProvider;
use Yii;

class BoardController extends Controller
{
    public function actionUsers(){
        $userSearch = new UserSearch();
        $dataProvider = $userSearch->search(Yii::$app->request->get());

        return $this->render('users',[
           'provider' => $dataProvider,
           'searchModel' => $userSearch,
        ]);
    }

    public function actionTourRequests(){

        $userTourSearch = new UserTourSearch();
        $dataProvider = $userTourSearch->search(Yii::$app->request->get());

        return $this->render('tour-requests',[
            'provider' => $dataProvider,
            'searchModel' => $userTourSearch,
        ]);
    }

    public function actionTourResponses(){
        $provider = new ActiveDataProvider([
            'query' => TourResponse::find()->where(['is_hot_tour' => 0]),
            'pagination' => [
                'pageSize' => 30,
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_ASC,
                    'country_id' => SORT_ASC,
                    'city_id' => SORT_DESC
                ],
            ],
        ]);
        return $this->render('tour-responses',[
            'provider' => $provider
        ]);
    }

    public function actionEmails(){
        return $this->render('emails');
    }
}