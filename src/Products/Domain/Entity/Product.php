<?php

namespace App\Products\Domain\Entity;


use App\Shared\Domain\Entity\EntityInterface;
use App\Shared\Infrastructure\Service\Identifier\IdentifierService;
use App\Warehouses\Domain\Entity\Warehouse;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;


class Product implements EntityInterface
{

    private $id;

    private string $title;

    private float $price;

    private int $availableCount;

    private ?Warehouse $warehouse;

    private Collection $orders;

    public function __construct()
    {
        $this->id = IdentifierService::generate();
        $this->title = '';
        $this->price = 0.0;
        $this->availableCount = 0;
        $this->warehouse = null;
        $this->orders = new ArrayCollection();
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
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @param string $title
     */
    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return int
     */
    public function getAvailableCount(): int
    {
        return $this->availableCount;
    }

    /**
     * @param int $availableCount
     */
    public function setAvailableCount(int $availableCount): self
    {
        $this->availableCount = $availableCount;

        return $this;
    }

    /**
     * @return Warehouse|null
     */
    public function getWarehouse(): ?Warehouse
    {
        return $this->warehouse;
    }

    /**
     * @param Warehouse|null $warehouse
     */
    public function setWarehouse(?Warehouse $warehouse): self
    {
        $this->warehouse = $warehouse;

        return $this;
    }

    /**
     * @return ArrayCollection
     */
    public function getOrders(): ArrayCollection
    {
        return $this->orders;
    }

    /**
     * @param ArrayCollection $orders
     */
    public function setOrders(ArrayCollection $orders): self
    {
        $this->orders = $orders;

        return $this;
    }
}