<?php
/*
|-----------------------------------------------------------------------
| SMTP Configuration
|-----------------------------------------------------------------------
*/

$smtp_config = [
    'host'     => 'localhost',
    'auth'     => false,
    'username' => 'youth@localhost.net',
    'password' => '123456',
    'secure'   => '',
    'port'     => 25,
    'debug'    => 0,
    'from'     => [
        'email' => 'youth@localhost.net',
        'name'  => 'Youth'
    ],
    'options'  => [
        'ssl'  => [
            'verify_peer'       => false,
            'verify_peer_name'  => false,
            'allow_self_signed' => true
        ]
    ]
];