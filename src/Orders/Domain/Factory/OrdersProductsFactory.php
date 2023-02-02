<?php

namespace App\Orders\Domain\Factory;

use App\Orders\Domain\Entity\Order;
use App\Orders\Domain\Entity\OrdersProducts;
use App\Products\Domain\Entity\Product;

class OrdersProductsFactory
{
    public static function create(Order $order, Product $product, int $orderedCount): OrdersProducts
    {
        $ordersProductsRelation = new OrdersProducts();
        $ordersProductsRelation
            ->setOrder($order)
            ->setProduct($product)
            ->setOrderedCount($orderedCount)
        ;

        return $ordersProductsRelation;
    }

}