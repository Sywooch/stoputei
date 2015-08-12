<?php

namespace app\models;

use Yii;
use yii\db\ActiveRecord;
use yii\db\Expression;

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
            'password' => \Yii::t('app', 'Password')
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

    public function getFavourites(){
        return $this->hasMany(UserTourFavourites::className(), ['user_id' => 'id']);
    }
}
