<?php

declare(strict_types=1);

namespace HydrationTest;

use Doctrine\ORM\Mapping\Driver\AnnotationDriver;

use const DIRECTORY_SEPARATOR;

return [
    'doctrine' => [
        'driver' => [
            __NAMESPACE__ . '_driver' => [
                'class' => AnnotationDriver::class,
                'cache' => 'array',
                'paths' => [
                    __DIR__ . '/../src/Entity',
                ],
            ],
            'orm_default' => [
                'drivers' => [
                    __NAMESPACE__ . '\Entity' => __NAMESPACE__ . '_driver',
                ],
            ],
        ],
    ],
    'router' => [
        'routes' => require __DIR__ . DIRECTORY_SEPARATOR . 'routes.config.php',
    ],
    'controllers' => require __DIR__ . DIRECTORY_SEPARATOR . 'controllers.config.php',
    'form_elements' => require __DIR__ . DIRECTORY_SEPARATOR . 'forms.config.php',
    'input_filters' => require __DIR__ . DIRECTORY_SEPARATOR . 'inputfilters.config.php',
    'view_manager' => [
        'display_not_found_reason' => true,
        'display_exceptions' => true,
        'doctype' => 'HTML5',
        'exception_template' => 'error/index',
        'template_path_stack' => [
            __DIR__ . '/../view',
        ],
        'strategies' => [
            'ViewJsonStrategy',
        ],
    ],
];
