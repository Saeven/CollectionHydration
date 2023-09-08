<?php

declare(strict_types=1);

namespace HydrationTest\Factory\Form;

use Doctrine\ORM\EntityManager;
use HydrationTest\Entity\Ingredient;
use HydrationTest\Entity\IngredientAmount;
use HydrationTest\Form\Hydrator\CollectionComparatorHydrator;
use HydrationTest\Form\IngredientAmountFieldset;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class IngredientAmountFieldsetFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $recipe = $options['recipe'];

        /** @var  EntityManager $entityManager */
        $entityManager = $container->get(EntityManager::class);
        $collectionHydrator = new CollectionComparatorHydrator($entityManager, function (array $data, object $object) use ($entityManager, $recipe) {
            $ingredient = $entityManager->getRepository(Ingredient::class)->findOneBy(['id' => $data['ingredient']]);
            return new IngredientAmount($recipe, $ingredient, $data['tablespoons'] ?? 0);
        }, false);


        return (new IngredientAmountFieldset($entityManager, 'ingredient_amounts'))
            ->setHydrator($collectionHydrator)
            ->setObject(new IngredientAmount($options['recipe'], null, null));
    }
}
