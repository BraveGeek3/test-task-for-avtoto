<?php

namespace App\Products\Infrastructure\Repository;

use App\Products\Domain\Entity\Product;
use App\Products\Domain\Repository\ProductRepositoryInterface;
use App\Warehouses\Domain\Entity\Warehouse;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ProductRepository extends ServiceEntityRepository implements ProductRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Product::class);
    }

    public function add(Product $product)
    {
        $this->_em->persist($product);
        $this->_em->flush();
    }

    public function findByTitle(string $title): ?Product
    {
        return parent::findOneBy(['title' => $title]);
    }

    public function findById(string $id): ?Product
    {
        return parent::findOneBy(['id' => $id]);
    }

    public function findByWarehouse(Warehouse $warehouse): array
    {
        return parent::findBy(['warehouse' => $warehouse]);
    }

//    public function findWarehouse(string $warehouseId): ?Product
//    {
//
//    }
}