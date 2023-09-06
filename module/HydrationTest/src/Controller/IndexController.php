<?php

declare(strict_types=1);

namespace HydrationTest\Controller;

use Doctrine\ORM\EntityManager;
use Exception;
use HydrationTest\Entity\Ingredient;
use HydrationTest\Entity\Recipe;
use HydrationTest\Form\RecipeForm;
use Laminas\Form\FormElementManager;
use Laminas\Mvc\Controller\AbstractActionController;
use Laminas\View\Model\JsonModel;
use Laminas\View\Model\ModelInterface;
use Laminas\View\Model\ViewModel;

class IndexController extends AbstractActionController
{
    private EntityManager $entityManager;
    private FormElementManager $formElementManager;

    public function __construct(EntityManager $entityManager, FormElementManager $formElementManager)
    {
        $this->entityManager = $entityManager;
        $this->formElementManager = $formElementManager;
    }

    public function indexAction(): ModelInterface
    {
        return (new ViewModel())
            ->setTerminal(true);
    }

    public function setAction(): ModelInterface
    {
        $clear = [
            "DELETE FROM HydrationTest\Entity\Recipe",
            "DELETE FROM HydrationTest\Entity\Ingredient",
        ];

        foreach ($clear as $query) {
            $this->entityManager->createQuery($query)->execute();
        }

        // Ingredients

        $flour = new Ingredient(1, "Flour");
        $eggs = new Ingredient(2, "Eggs");

        $this->entityManager->persist($flour);
        $this->entityManager->persist($eggs);
        $this->entityManager->persist(new Ingredient(3, "Gluten Free Flour"));

        // Recipe & Amounts

        $recipe = new Recipe(1, "Bread");
        $recipe->addIngredient($flour, 10);
        $recipe->addIngredient($eggs, 5);
        $this->entityManager->persist($recipe);

        $this->entityManager->flush();

        return new JsonModel([
            'success' => true,
            'message' => "Entities have been reset",
            'recipe' => $recipe->listIngredients(),
        ]);
    }

    public function updateAction(): JsonModel
    {
        try {
            // let's simulate a post
            $postData = [
                'id' => 1,
                'title' => 'Gluten Free Bread',
                'ingredient_amounts' => [
                    0 => [
                        'ingredient' => 2, // we're keeping the eggs
                        'tablespoons' => 5,
                    ],
                    1 => [
                        'ingredient' => 3, // but are replacing flour, with gluten free flour
                        'tablespoons' => 10,
                    ],
                ],
            ];

            $recipeForm = $this->formElementManager->build(RecipeForm::class, [
                'recipe' => $this->entityManager->getRepository(Recipe::class)->findOneBy([
                    'id' => 1,
                ]),
            ]);

            $recipeForm->setData($postData);
            if (!$recipeForm->isValid()) {
                return new JsonModel([
                    $recipeForm->getMessages(),
                ]);
            }

            /** @var Recipe $adjustedRecipe */
            $adjustedRecipe = $recipeForm->getObject();

            $this->entityManager->persist($adjustedRecipe);
            $this->entityManager->flush();
        } catch (Exception $x) {
            return new JsonModel([
                'success' => false,
                'message' => $x->getMessage(),
            ]);
        }

        return new JsonModel(['foo' => 'bar']);
    }
}
