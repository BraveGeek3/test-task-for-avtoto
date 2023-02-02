<?php

namespace App\Orders\Domain\Repository;

use App\Orders\Domain\Entity\Order;
use App\Shared\Domain\Repository\RepositoryInterface;

interface OrderRepositoryInterface extends RepositoryInterface
{
    public function findByTransportCompanyId(int $transportCompanyId): ?Order;
    public function findById(string $id): ?Order;
}