<?php

declare(strict_types=1);

namespace HydrationTest\Form\Hydrator;

use Doctrine\Inflector\Inflector;
use Doctrine\Laminas\Hydrator\Strategy\AbstractCollectionStrategy;
use HydrationTest\Model\CollectionDiff;
use HydrationTest\Model\CollectionDiffInterface;

class CollectionDiffStrategy extends AbstractCollectionStrategy
{
    private bool $projectValues;

    public function __construct(bool $projectValues, ?Inflector $inflector = null)
    {
        parent::__construct($inflector);
        $this->projectValues = $projectValues;
    }

    public function hydrate($value, ?array $data)
    {
        $collection = $this->getCollectionFromObjectByReference();
        $collectionArray = $collection->toArray();

        (new CollectionDiff($collectionArray, $value, $this->projectValues))
            ->processAdditions(function (CollectionDiffInterface $object) use ($collection) {
                $collection->add($object);
            })
            ->processRemovals(function (CollectionDiffInterface $object) use ($collection) {
                $collection->removeElement($object);
            });

        return $collection;
    }
}