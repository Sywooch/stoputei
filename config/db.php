<?php
if($_SERVER['HTTP_HOST'] == 'amazing-tour') {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=amazing-tour',
        'username' => 'root',
        'password' => 'qwerty',
        'charset' => 'utf8',
    ];
}else{
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=u943820889_tour',
        'username' => 'u943820889_user',
        'password' => 'qwerty',
        'charset' => 'utf8',
    ];
}
