<?php

namespace App\Warehouses\Domain\Repository;

use App\Products\Domain\Entity\Product;
use App\Shared\Domain\Entity\Address\Address;
use App\Shared\Domain\Repository\RepositoryInterface;
use App\Warehouses\Domain\Entity\Warehouse;

interface WarehouseRepositoryInterface extends RepositoryInterface
{
    public function findById(string $warehouseId): ?Warehouse;
    public function findByAddress(Address $address): ?Warehouse;
    public function findByProduct(Product $product): ?Warehouse;
    public function findByFullAddress(array $address): ?Warehouse;


}