<?php

namespace App\Warehouses\Infrastructure\Repository;



use App\Products\Domain\Entity\Product;
use App\Shared\Domain\Entity\Address\Address;
use App\Shared\Domain\Entity\EntityInterface;
use App\Warehouses\Domain\Entity\Warehouse;
use App\Warehouses\Domain\Repository\WarehouseRepositoryInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class WarehouseRepository extends ServiceEntityRepository implements WarehouseRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Warehouse::class);
    }

    public function save(EntityInterface $warehouse): void
    {
        $this->_em->persist($warehouse);
        $this->_em->flush();
    }

    public function remove(EntityInterface $warehouse): void
    {
        $this->_em->remove($warehouse);
        $this->_em->flush();
    }

    public function findById(string $warehouseId): ?Warehouse
    {
        return parent::findOneBy(['id' => $warehouseId]);
    }

    public function findByAddress(Address $address): ?Warehouse
    {
        return parent::findOneBy(['address' => $address]);
    }

    public function findByProduct(Product $product): ?Warehouse
    {
        return parent::findOneBy(['products' => $product]);
    }

    public function findByFullAddress(array $address): ?Warehouse
    {
        return parent::findOneBy([
            'region' => $address['region'],
            'city' => $address['city'],
            'street' => $address['street'],
            'buildingNumber' => $address['buildingNumber']
        ]);
    }

}