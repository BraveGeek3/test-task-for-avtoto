<?php

namespace App\Warehouses\Domain\Entity;

use App\Products\Domain\Entity\Product;
use App\Shared\Domain\Entity\Address\Address;
use App\Shared\Domain\Entity\EntityInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Warehouse implements EntityInterface
{
    private $id;

    private ?Address $address;

    private ?Collection $products;

    public function __construct()
    {
        $this->address = null;
        $this->products = new ArrayCollection();
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
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     */
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }

    /**
     * @return Collection|null
     */
    public function getProducts(): ?Collection
    {
        return $this->products;
    }

    /**
     * @param ArrayCollection|null $products
     */
    public function setProducts(?ArrayCollection $products): void
    {
        $this->products = $products;
    }

    public function addProduct(Product $product): self {
        if (!$this->products->contains($product)) {
            $this->products->add($product);
        }

        return $this;
    }


}