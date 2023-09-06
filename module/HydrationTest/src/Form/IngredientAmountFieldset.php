<?php

declare(strict_types=1);

namespace HydrationTest\Form;

use Doctrine\ORM\EntityManager;
use DoctrineModule\Form\Element\ObjectSelectV3Polyfill as ObjectSelect;
use HydrationTest\Entity\Ingredient;
use Laminas\Filter\ToInt;
use Laminas\Form\Element\Number;
use Laminas\Form\Fieldset;
use Laminas\InputFilter\InputFilterProviderInterface;
use Laminas\Validator\GreaterThan;

class IngredientAmountFieldset extends Fieldset implements InputFilterProviderInterface
{
    private EntityManager $entityManager;

    public function __construct(EntityManager $entityManager, string $name, array $options = [])
    {
        parent::__construct($name, $options);
        $this->entityManager = $entityManager;
    }

    public function init()
    {
        $this->add([
            'name' => 'ingredient',
            'type' => ObjectSelect::class,
            'options' => [
                'property' => 'id',
                'target_class' => Ingredient::class,
                'object_manager' => $this->entityManager,
            ],
        ]);

        $this->add([
            'name' => 'tablespoons',
            'type' => Number::class,
            'options' => [
                'labe' => 'Total TBSP',
            ],
        ]);
    }

    public function getInputFilterSpecification(): array
    {
        return [
            'tablespoons' => [
                'required' => true,
                'filters' => [
                    ['name' => ToInt::class],
                ],
                'validators' => [
                    [
                        'name' => GreaterThan::class,
                        'options' => [
                            'min' => 1,
                            'inclusive' => true,
                        ],
                    ],
                ],
            ],
        ];
    }
}
