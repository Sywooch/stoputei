<?php

return [
    'application_name' => 'stoputei',
    'adminEmail' => 'noreply@stoputei.com',
    'adminEmailMain' => 'admin@stoputei.com',
    'adminPhone' => '+380501234567',
    'adminEmailContact' => 'azbukin777@gmail.com',
    'api' => [
        "soap_login" => "Timateo83@gmail.com",
        "soap_password" => "123456789",
        "wsdl" => "http://module.sletat.ru/XmlGate.svc?singleWSDL",
        "namespace" => "urn:SletatRu:DataTypes:AuthData:v1"
    ],
    'payment' => [
        'liqpay' => [
            'public_key' => 'i40207279078',
            'private_key' => 'BCEBcuzJ8jF3n2eTqJD7LE3gsVI0bKdY7m7kzDDi'
        ]
    ],
    'hash' => 'ffd96fd7bf8dybgfdh69gvfv9df9vfofv',
    'depart_countries' => [16, 53, 62, 64, 66, 79, 150, 121, 124],
    'authLoginTime' => 60*15
];
