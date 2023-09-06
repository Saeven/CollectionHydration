<?php

declare(strict_types=1);

namespace HydrationTest\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

use function sprintf;

/**
 * @ORM\Entity
 * @ORM\Table(name="recipes");
 */
class Recipe
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer", nullable=false, options={"unsigned"=true})
     *
     * @var int
     */
    private $id;

    /**
     * @ORM\Column(type="string", nullable=false)
     *
     * @var string
     */
    private $title;

    /**
     * @ORM\OneToMany(targetEntity="IngredientAmount", mappedBy="recipe", cascade={"all"}, orphanRemoval=true)
     *
     * @var Collection<IngredientAmount>
     */
    private $ingredient_amounts;

    public function __construct(int $id, string $title)
    {
        $this->id = $id;
        $this->title = $title;
        $this->ingredient_amounts = new ArrayCollection();
    }

    public function addIngredient(Ingredient $ingredient, int $amount): self
    {
        foreach ($this->ingredient_amounts as $ingredientAmount) {
            if ($ingredientAmount->getIngredient() === $ingredient) {
                $ingredientAmount->setTablespoons($amount);
                return $this;
            }
        }

        $this->ingredient_amounts->add(new IngredientAmount($this, $ingredient, $amount));
        return $this;
    }

    public function listIngredients(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'ingredients' => $this->ingredient_amounts->map(function (IngredientAmount $amount) {
                return sprintf("%s, %d tsp", $amount->getIngredient()->getName(), $amount->getTablespoons());
            })->toArray(),
        ];
    }

    /**
     * @return Collection<IngredientAmount>
     */
    public function getIngredientAmounts(): Collection
    {
        return $this->ingredient_amounts;
    }
}
