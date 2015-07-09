<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<p>
    <?= Html::a(Yii::t('app','Follow this link to verify your account'), Url::to(['site/verify', 'email' => $email, 'token' => $token], [true]));?>
</p>
    <h4><?=Yii::t('app', 'Site home page');?></h4>
    <?= Html::a(Yii::$app->params['application_name'], Url::home('http')) ?>