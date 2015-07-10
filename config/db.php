<?php
//On dev and test environment need change dbname, username,
// password on real for this environment
    return [
        'class' => 'yii\db\Connection',
        'dsn' => 'mysql:host=localhost;dbname=amazing-tour',
        'username' => 'root',
        'password' => 'qwerty',
        'charset' => 'utf8',
    ];
