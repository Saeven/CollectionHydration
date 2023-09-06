<?php

declare(strict_types=1);

namespace HydrationTest\Factory\Form;

use Doctrine\Laminas\Hydrator\DoctrineObject as DoctrineHydrator;
use Doctrine\Laminas\Hydrator\Strategy\AllowRemoveByReference;
use Doctrine\ORM\EntityManager;
use HydrationTest\Form\IngredientAmountFieldset;
use HydrationTest\Form\RecipeForm;
use Laminas\Form\FormElementManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RecipeFormFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $hydrator = new DoctrineHydrator($container->get(EntityManager::class), false);
        $hydrator->addStrategy('ingredient_amounts', new AllowRemoveByReference());

        return (new RecipeForm(
            $container->get(FormElementManager::class)->get(IngredientAmountFieldset::class, $options ?? []),
            $options ?? []
        ))->setHydrator($hydrator)
            ->setObject($options['recipe']);
    }
}
