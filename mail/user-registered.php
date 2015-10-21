<?php
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\User;

/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

$userInfo = User::findOne($user->id);
?>
<br>
<p>
    <?php if($user->role == 2):?>
        <p>На сайте СтоПутей зарегистрировался новый менеджер <?=$userInfo->email;?><p>
        <p>Город
    <?php else:?>
        На сайте СтоПутей зарегистрировался новый пользователь: <?=$userInfo->email;?>
    <?php endif;?>
</p>