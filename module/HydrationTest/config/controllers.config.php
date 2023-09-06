<?php

declare(strict_types=1);

namespace HydrationTest;

use HydrationTest\Controller\IndexController;
use HydrationTest\Factory\Controller\IndexControllerFactory;

return [
    'factories' => [
        IndexController::class => IndexControllerFactory::class,
    ],
];
