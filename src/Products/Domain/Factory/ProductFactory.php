<?php

namespace App\Products\Domain\Factory;

use App\Products\Domain\Entity\Product;
use App\Products\Domain\ValueObject\CreateProductRequest;

class ProductFactory
{
    public static function create(CreateProductRequest $dto): Product
    {
        $product = new Product();
        $product
            ->setTitle($dto->getTitle())
            ->setPrice($dto->getPrice())
            ->setAvailableCount($dto->getAvailableCount())
        ;

        return $product;
    }

}