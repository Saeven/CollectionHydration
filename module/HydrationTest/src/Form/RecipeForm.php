<?php

declare(strict_types=1);

namespace HydrationTest\Form;

use Laminas\Form\Element\Collection;
use Laminas\Form\Element\Text;
use Laminas\Form\Fieldset;
use Laminas\Form\Form;

class RecipeForm extends Form
{
    private Fieldset $ingredientFieldset;

    public function __construct(Fieldset $ingredientFieldset, array $options)
    {
        $this->ingredientFieldset = $ingredientFieldset;
        parent::__construct('recipe_form', $options);
    }

    public function init()
    {
        $this->add([
            'name' => 'title',
            'type' => Text::class,
            'options' => [
                'label' => 'Title',
            ],
        ]);

        $this->add([
            'name' => 'ingredient_amounts',
            'type' => Collection::class,
            'options' => [
                'label' => 'Ingredient Amounts',
                'allow_add' => true,
                'target_element' => $this->ingredientFieldset,
            ],
        ]);
    }
}
