<?php

namespace App\Tests\Utils;

use App\Shared\Domain\Entity\EntityInterface;
use App\Shared\Domain\Repository\RepositoryInterface;

trait CleanUpUtil
{
    public function cleanUp(RepositoryInterface $repository, EntityInterface $entity): void
    {
        $repository->remove($entity);
    }
}