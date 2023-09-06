<?php

declare(strict_types=1);

namespace HydrationTest\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipes_ingredients");
 */
class IngredientAmount
{
    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Recipe", inversedBy="ingredient_amounts")
     * @ORM\JoinColumn(name="recipe_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var Recipe
     */
    private $recipe;

    /**
     * @ORM\Id
     * @ORM\ManyToOne(targetEntity="Ingredient")
     * @ORM\JoinColumn(name="ingredient_id", referencedColumnName="id", onDelete="cascade")
     *
     * @var ?Ingredient
     */
    private $ingredient;

    /**
     * @ORM\Column(type="integer", nullable=false, options={"default":0, "unsigned":true})
     *
     * @var ?int
     */
    private $tablespoons;

    public function __construct(Recipe $recipe, ?Ingredient $ingredient, ?int $tablespoons)
    {
        $this->recipe = $recipe;
        $this->ingredient = $ingredient;
        $this->tablespoons = $tablespoons;
    }

    public function getIngredient(): Ingredient
    {
        return $this->ingredient;
    }

    public function setTablespoons(int $tablespoons): void
    {
        $this->tablespoons = $tablespoons;
    }

    public function getTablespoons(): int
    {
        return $this->tablespoons;
    }
}
