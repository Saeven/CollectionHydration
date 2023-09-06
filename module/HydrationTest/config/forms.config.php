<?php

declare(strict_types=1);

namespace HydrationTest;

use HydrationTest\Factory\Form\IngredientAmountFieldsetFactory;
use HydrationTest\Factory\Form\RecipeFormFactory;
use HydrationTest\Form\IngredientAmountFieldset;
use HydrationTest\Form\RecipeForm;

return [
    'factories' => [
        RecipeForm::class => RecipeFormFactory::class,
        IngredientAmountFieldset::class => IngredientAmountFieldsetFactory::class,
    ],
];
