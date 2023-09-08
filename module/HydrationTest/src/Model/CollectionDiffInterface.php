<?php

declare(strict_types=1);

namespace HydrationTest\Model;

interface CollectionDiffInterface
{
    public function getDiffIdentifier(): string;

    public function copyValuesFrom(object $object): void;
}
