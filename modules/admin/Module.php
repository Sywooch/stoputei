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
            throw new \yii\web\HttpException(400);
        }
    }
}