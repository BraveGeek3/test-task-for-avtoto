<?php

namespace App\Shared\Domain\Repository;

use App\Shared\Domain\Entity\EntityInterface;

interface RepositoryInterface
{
    public function save(EntityInterface $entity): void;
    public function remove(EntityInterface $entity): void;
}