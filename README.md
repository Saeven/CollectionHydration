# Hydrator Test

Used to highlight an issue (perhaps with my wiring) of a fieldset that serves a collection on an Entity.

For the test's sake, we have Recipes that reference Ingredients via IngredientAmount; a join entity that adds a detail, tablespoons.  Creative, I know!

Rather that replacing the sub-entity, Doctrine attempts to issue update queries which leads to duplicate key collisions.

## Setup

This rig assumes that you have a MySQL database available.  Edit config/autoload/database.local.php so that it contains credentials that can grant access to your MySQL, and then use the doctrine-module CLI to generate the schema:

```
./vendor/bin/doctrine-module orm:schema-tool:update --force
```

## Operation

* Serve the project with `composer serve`
* Access /
* Click on the "Reset Entities" button (can do this anytime), this will populate the database
* Click on "simulate a processed form" to see how hydration reacts
* Note the UPDATE error with the key collision

## The Issue

When calling the /set route (Reset Entities), we're setting a recipe with two ingredients.  The result is this table data:

**Recipe Table**

|id|title|
|--|-----|
|1 | bread |

**Ingredient Table**

| id | name  |
|----|-------|
| 1  | Flour |
| 2  | Eggs  |
| 3 | Gluten Free Flour |

**IngredientAmount Table**

| recipe_id | ingredient_id | tablespoons |
| ------ |---------------|-------------|
| 1 | 1             | 10          |
| 1 | 2             | 5           |

> Then, we attempt to issue an update with this POST simulation via Form

```
    [
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
```

Note that the post no longer contains ingredient 1, the intention is to replace ingredient 1 with ingredient 3.

At this point, instead of removing an ingredient to insert another, Doctrine creates SQL that generates a duplicate key collision:

```
UPDATE recipes_ingredients 
SET tablespoons = ?, ingredient_id = ? 
WHERE recipe_id = ? AND ingredient_id = ?
with params [5, 2, 1, 1]
```

As evidenced, it is trying to update ingredient 1's id, to be ingredient 2.  
Since ingredient 2 is being retained, this update causes a duplicate collision.
