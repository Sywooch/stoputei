<?php
//On dev and test environment need change dbname, username,
// password on real for this environment
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=stoputei_prod',
        'username' => 'us_stoputei_prod',
        'password' => 'QazWsxEdc1234',
        'charset' => 'utf8',
    ];
