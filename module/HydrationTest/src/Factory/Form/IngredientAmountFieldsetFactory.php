<?php

declare(strict_types=1);

namespace HydrationTest\Factory\Form;

use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager;
use HydrationTest\Entity\IngredientAmount;
use HydrationTest\Form\IngredientAmountFieldset;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IngredientAmountFieldsetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $entityManager = $container->get(EntityManager::class);
        return (new IngredientAmountFieldset($entityManager, 'ingredient_amounts'))
            ->setHydrator(new DoctrineHydrator($entityManager, false))
            ->setObject(new IngredientAmount($options['recipe'], null, null));
    }
}
