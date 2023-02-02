<?php

namespace App\Orders\Domain\Entity;

use App\Products\Domain\Entity\Product;
use App\Shared\Domain\Entity\EntityInterface;
use App\Shared\Infrastructure\Service\Identifier\IdentifierService;

class OrdersProducts implements EntityInterface
{
    private $id;

    private Product $product;

    private Order $order;

    private int $orderedCount;

    public function __construct()
    {
        $this->id = IdentifierService::generate();
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

//    /**
//     * @param mixed $id
//     */
//    public function setId($id): void
//    {
//        $this->id = $id;
//    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Order
     */
    public function getOrder(): Order
    {
        return $this->order;
    }

    /**
     * @param Order $order
     */
    public function setOrder(Order $order): self
    {
        $this->order = $order;

        return $this;
    }

    /**
     * @return int
     */
    public function getOrderedCount(): int
    {
        return $this->orderedCount;
    }

    /**
     * @param int $orderedCount
     */
    public function setOrderedCount(int $orderedCount): self
    {
        $this->orderedCount = $orderedCount;

        return $this;
    }


}