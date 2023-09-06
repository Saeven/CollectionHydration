<?php

declare(strict_types=1);

namespace HydrationTest\Factory\Controller;

use Doctrine\ORM\EntityManager;
use HydrationTest\Controller\IndexController;
use Laminas\Form\FormElementManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IndexControllerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new IndexController(
            $container->get(EntityManager::class),
            $container->get(FormElementManager::class)
        );
    }
}
