<?php

declare(strict_types=1);

namespace HydrationTest\Factory\Form;

use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\ORM\EntityManager;
use Exception;
use HydrationTest\Entity\IngredientAmount;
use HydrationTest\Form\IngredientAmountFieldset;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IngredientAmountFieldsetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        try {
            $entityManager = $container->get(EntityManager::class);
            $fieldset = new IngredientAmountFieldset($entityManager, 'ingredient_amounts');
            $fieldset->setHydrator(new DoctrineHydrator($entityManager, false));
            $fieldset->setObject(new IngredientAmount($options['recipe'], null, null));

            return $fieldset;
        } catch (Exception $x) {
            die($x->getMessage());
        }
    }
}
