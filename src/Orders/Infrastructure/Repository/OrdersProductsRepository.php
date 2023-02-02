<?php

namespace App\Orders\Infrastructure\Repository;

use App\Orders\Domain\Entity\Order;
use App\Orders\Domain\Entity\OrdersProducts;
use App\Products\Domain\Entity\Product;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrdersProductsRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, OrdersProducts::class);
    }

    public function findByProduct(Product $product): ?OrdersProducts
    {
        return parent::findOneBy(['product_id' => $product]);
    }

    public function findByOrder(Order $order): ?OrdersProducts
    {
        return parent::findOneBy(['order_id' => $order]);
    }
}