<?php

declare(strict_types=1);

namespace HydrationTest\Form\Hydrator;

use Doctrine\Inflector\Inflector;
use Doctrine\Laminas\Hydrator\DoctrineObject;
use Doctrine\Persistence\ObjectManager;

class CollectionComparatorHydrator extends DoctrineObject
{
    /** @var callable */
    private $instantiationClosure;

    public function __construct(ObjectManager $objectManager, $instantiationClosure, $byValue = true, ?Inflector $inflector = null)
    {
        $this->instantiationClosure = $instantiationClosure;
        parent::__construct($objectManager, $byValue, $inflector);
    }

    public function hydrate(array $data, object $object)
    {
        return call_user_func($this->instantiationClosure, $data, $object);
    }
}