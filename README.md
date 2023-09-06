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

