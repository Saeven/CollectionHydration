<?php

use Doctrine\DBAL\Driver\PDO\MySQL\Driver;

return [
    'doctrine' => [
        'configuration' => [
            'orm_default' => [
                'generate_proxies' => true,
                'metadata_cache' => 'array',
                'query_cache' => 'array',
                'result_cache' => 'array',
            ],
        ],
        'connection' => [
            'orm_default' => [
                'driverClass' => Driver::class,
                'params' => [
                    'host' => '127.0.0.1',
                    'user' => 'hydration',
                    'password' => 'hydration',
                    'dbname' => 'hydration',
                    'port' => '3306',
                    'driverOptions' => [
                        1002 => 'SET NAMES utf8',
                    ],
                ],
            ],
        ],
    ],
];
