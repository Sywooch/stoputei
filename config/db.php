<?php
if($_SERVER['HTTP_HOST'] == 'amazing-tour') {
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=amazing-tour',
        'username' => 'root',
        'password' => 'qwerty',
        'charset' => 'utf8',
    ];
}elseif($_SERVER['HTTP_HOST'] == 'dev.stoputei.com'){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=stoputei_dev',
        'username' => 'us_stoputei_dev',
        'password' => 'QazWsxEdc1234',
        'charset' => 'utf8',
    ];
}elseif($_SERVER['HTTP_HOST'] == 'stoputei.com'){
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=stoputei',
        'username' => 'us_stoputei',
        'password' => 'PQazWsxEdc1234',
        'charset' => 'utf8',
    ];
}
