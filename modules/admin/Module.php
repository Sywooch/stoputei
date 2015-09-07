<?php
namespace app\modules\admin;

class Module extends \yii\base\Module
{
    public function init()
    {
        parent::init();

        $this->params['foo'] = 'bar';
        // ...  other initialization code ...
        if(\Yii::$app->user->identity->role != 3){
            if(\Yii::$app->user->identity->role != 3){
                return $this->goHome();
            }
        }
    }
}