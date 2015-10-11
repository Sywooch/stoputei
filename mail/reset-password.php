<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<br>
<p>
    Чтобы восставновить ваш пароль от аккаунта - перейдите по ссылке <?=Html::a(Yii::t('app', 'Restore password'), Url::to(['site/password-reset', 'token' => $token], [true]));?>
</p>