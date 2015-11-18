<?php

namespace app\models;

use app\modules\admin\models\Email;
use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;
use app\models\City;

class User extends ActiveRecord implements \yii\web\IdentityInterface
{
    public static function tableName()
    {
        return 'users';
    }

    public function rules(){
        return [
          [['password','email'], 'required'],
          ['email', 'email'],
          ['email', 'unique'],
          ['password', 'string', 'max' => 50]
        ];
    }

    public function attributeLabels()
    {
        return [
            'email' => \Yii::t('app','Email'),
            'password' => \Yii::t('app', 'Password'),
            'role' => \Yii::t('app', 'Role admin'),
            'region_id' => \Yii::t('app', 'Region'),
            'city.name' => \Yii::t('app', 'Which region'),
            'created_at' => \Yii::t('app', 'Created at admin'),
            'updated_at' => \Yii::t('app', 'Last enter'),
            'company_name' => \Yii::t('app', 'Company name'),
            'company_phone' => \Yii::t('app', 'Phone'),
            'company_city' => \Yii::t('app', 'City'),
            'single_region_paid' => \Yii::t('app', 'Payment "Region"'),
            'multiple_region_paid' => \Yii::t('app', 'Payment "Country"'),
            'approved' => \Yii::t('app', 'Approved'),
        ];
    }

/**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        //return isset(self::$users[$id]) ? new static(self::$users[$id]) : null;

        //if (Yii::$app->getSession()->has('user-'.$id)) {
        //    return new self(Yii::$app->getSession()->get('user-'.$id));
        //}else{
            return static::findOne($id);
        //}
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        /*foreach (self::$users as $user) {
            if ($user['accessToken'] === $token) {
                return new static($user);
            }
        }
        return null;*/

        return static::findOne(['access_token' => $token]);
    }

    /**
     * Finds user by email
     *
     * @param  string      $username
     * @return static|null
     */
    public static function findByEmail($email)
    {
        /*foreach (self::$users as $user) {
            if (strcasecmp($user['username'], $username) === 0) {
                return new static($user);
            }
        }
        return null;*/
        return static::findOne(['email' => $email]);
    }

    public static function findByPasswordResetToken($token)
    {
        return static::findOne(['reset_password_token' => $token]);
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    public function generateAuthKey()
    {
        $this->auth_key = md5(uniqid().\Yii::$app->params['hash']);
    }

/**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->auth_key === $authKey;
    }

    public function setPassword($password)
    {
        $this->password = md5($password);
    }

    /**
     * Validates password
     *
     * @param  string  $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return $this->password === md5($password);
    }

    public function setVerifyCode(){
        return $this->verify = md5(uniqid().Yii::$app->params['hash']);
    }

    public function getVerifyCode($email){
        $user = self::findByEmail($email);
        $verify_code = $user->verify;
        return (empty($verify_code))?true:false;
    }

    public function isApproved($email){
        $user = self::findByEmail($email);
        return ($user->approved == 1)?true:false;
    }

    public function verify($email, $token){
        $user = self::find()->where(['email' => $email, 'verify' => $token])->one();
        if(!is_null($user)) {
            $user->verify = null;
            if($user->role == 1){
                $user->approved = 1;
            }
            if ($user->save()) {
                return true;
            } else {
                return false;
            }
        }else{
            return true;
        }
    }

    public function beforeSave($insert)
    {
        if (parent::beforeSave($insert)) {
            if ($insert) {
                $this->updated_at = new Expression('NOW()');
            }
            if($this->isNewRecord){
                $this->created_at = new Expression('NOW()');
                $this->generateAuthKey();
            }
            return true;
        }
        return false;
    }

    public function beforeDelete()
    {
        if (parent::beforeDelete()) {
            UserTourFavourites::deleteAll(['user_id' => $this->id]);
            UserFlight::deleteAll(['owner_id' => $this->id]);
            if($this->role == 1) {
                UserTour::deleteAll(['owner_id' => $this->id]);
            }elseif($this->role == 2){
                TourResponse::deleteAll(['manager_id' => $this->id]);
                FlightResponse::deleteAll(['manager_id' => $this->id]);
            }
            return true;
        }
        return false;
    }

    public function getFavourites(){
        return $this->hasMany(UserTourFavourites::className(), ['user_id' => 'id']);
    }

    public function getCity(){
        return $this->hasOne(DepartCity::className(), ['city_id' => 'region_id']);
    }

    public function getAdminEmails(){
        return $this->hasOne(Email::className(), ['user_id' => 'id']);
    }

    public static function isPaymentExpired($type_of_payment, $user_id = null){
        if(is_null($user_id)){
            $user_id = Yii::$app->user->identity->getId();
        }
        $user = self::find()->where(['id' => $user_id, $type_of_payment => 1])->one();
        switch($type_of_payment){
            case 'single_region_paid':
                $isExpired = strtotime($user->single_license_expire) < strtotime('now');
                break;
            case 'multiple_region_paid':
                $isExpired = strtotime($user->multiple_license_expire) < strtotime('now');
                break;
        }
        return $isExpired;
    }
}
