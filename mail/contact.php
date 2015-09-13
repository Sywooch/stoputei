<?php
use yii\helpers\Html;
use yii\helpers\Url;


/* @var $this \yii\web\View view component instance */
/* @var $message \yii\mail\BaseMessage instance of newly created mail message */

?>
<h2>
    Вы получили новое сообщение от пользователя <?=$name;?> (<?=$email;?>).
</h2>
<p>
    <h3>
    Тема письма :
    </h3>
</p>
<p>
    <?=$subject;?>
</p>
<br>
<p>
    <h4>
    Письмо :
    </h4>
</p>
<p>
    <?=$body;?>
</p>