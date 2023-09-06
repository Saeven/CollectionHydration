<?php

declare(strict_types=1);

namespace HydrationTest;

use HydrationTest\Controller\IndexController;
use Laminas\Router\Http\Literal;

return [
    'index' => [
        'type' => Literal::class,
        'options' => [
            'route' => '/',
            'defaults' => [
                'controller' => IndexController::class,
                'action' => 'index',
            ],
        ],
    ],
    'set' => [
        'type' => Literal::class,
        'options' => [
            'route' => '/set',
            'defaults' => [
                'controller' => IndexController::class,
                'action' => 'set',
            ],
        ],
    ],
    'update' => [
        'type' => Literal::class,
        'options' => [
            'route' => '/update',
            'defaults' => [
                'controller' => IndexController::class,
                'action' => 'update',
            ],
        ],
    ],
];
