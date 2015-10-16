<?php

namespace app\modules\admin\controllers;

use app\models\User;
use app\models\UserEditForm;
use yii\helpers\Json;
use yii\web\Controller;
use Yii;

class UsersController extends Controller
{
    public function actionEdit($id){
        $model = new UserEditForm();
        if(is_null($id)){
            return $this->redirect(['/admin/board/users']);
        }else {
            $user = User::findOne($id);
            $model->email = $user->email;
            $model->region_id = $user->city->name;
            $model->role = $user->role;
            if($user->role == 1) {
                $model->approved = $user->approved;
            }elseif($user->role == 2){
                $model->approved = $user->approved;
                $model->company_name = $user->company_name;
                $model->company_city = $user->company_city;
                $model->company_phone = $user->company_phone;
                $model->company_address = $user->company_address;
                $model->company_street = $user->company_street;
                $model->single_region_paid = $user->single_region_paid;
                $model->multiple_region_paid = $user->multiple_region_paid;
            }
            if ($model->load(Yii::$app->request->post()) and $model->validate()) {
                $user->role = $model->role;
                $user->approved = $model->approved;
                $user->company_name = $model->company_name;
                $user->company_city = $model->company_city;
                $user->company_phone = $model->company_phone;
                $user->company_address = $model->company_address;
                $user->company_street = $model->company_street;
                $user->single_region_paid = $model->single_region_paid;
                $user->multiple_region_paid = $model->multiple_region_paid;
                if($user->save()){
                    Yii::$app->session->setFlash('success', 'SUCCESS');
                    if($model->role == 2) {
                        return $this->redirect(['/admin/board/managers']);
                    }else{
                        return $this->redirect(['/admin/board/users']);
                    }
                }else {
                    return $this->render('edit', [
                        'model' => $model,
                        'user' => $user
                    ]);
                }
            } else {
                return $this->render('edit', [
                    'model' => $model,
                    'user' => $user
                ]);
            }
        }
    }

    public function actionDelete($id){
        $user = User::findOne($id);
        if($user and $user->delete()){
            $response = [
                'message' => Yii::t('app', 'User was deleted successful'),
                'status' => 'ok',
                'id' => $id
            ];
            echo Json::encode($response);
            Yii::$app->end();
        }else{
            $response = [
                'message' => Yii::t('app', 'Something went wrong'),
                'status' => 'error'
            ];
            echo Json::encode($response);
            Yii::$app->end();
        }
    }
}