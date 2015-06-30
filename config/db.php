<?php
//On dev and test environment need change dbname, username,
// password on real for this environment
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=stoputei',
        'username' => 'us_stoputei',
        'password' => 'PQazWsxEdc1234',
        'charset' => 'utf8',
    ];
