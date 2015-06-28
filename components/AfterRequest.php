<?php
namespace app\components;
use \yii\base\Behavior;

class AfterRequest extends Behavior
{

    public $language_array = ['en','ru','uk'];

    public function events()
    {
        return [['on beforeAction',[$this,'setUserLocale']]];
    }

    public function setUserLocale(){
        $language = \Yii::$app->request->getAcceptableLanguages()[0];
        $pos = strpos($language,'-');
        if($pos !== false) {
            $short_language = substr($language, 0, $pos);
        }else{
            $short_language =$language;
        }
        if(in_array($short_language,$this->language_array)){
            \Yii::$app->language = $short_language;
        }else{
            \Yii::$app->language = 'en';
        }
    }
}