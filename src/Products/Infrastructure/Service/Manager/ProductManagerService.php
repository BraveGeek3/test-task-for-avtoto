<?php

namespace App\Products\Infrastructure\Service\Manager;

use App\Products\Domain\Entity\Product;
use App\Products\Domain\Factory\ProductFactory;
use App\Products\Domain\ValueObject\CreateProductRequest;
use App\Products\Infrastructure\Repository\ProductRepository;
use App\Warehouses\Domain\Entity\Warehouse;
use App\Warehouses\Infrastructure\Repository\WarehouseRepository;
use InvalidArgumentException;

class ProductManagerService
{
    private ProductRepository $productRepository;
    private WarehouseRepository $warehouseRepository;

    public function __construct(ProductRepository $repository, WarehouseRepository $warehouseRepository)
    {
        $this->productRepository = $repository;
        $this->warehouseRepository = $warehouseRepository;
    }

    public function addProduct(array $data): ?Product
    {
        $createProductDto = CreateProductRequest::createFromRequest($data);

        if (!$this->isUnique($createProductDto->getTitle())) {
            throw new InvalidArgumentException($createProductDto->getTitle() . " title aleready exists");
        }

        $product = ProductFactory::create($createProductDto);
//
//        if ($createProductDto->getWarehouseId() === null) {
//            return $product;
//        }

        if (($warehouse = $this->warehouseRepository->findById($createProductDto->getWarehouseId())) === null) {
            throw new InvalidArgumentException("Incorrect warehouse id");
        }

        $product->setWarehouse($warehouse);

        $this->productRepository->add($product);

        return $product;
    }

    private function isUnique(string $title): bool
    {
        return $this->productRepository->findByTitle($title) === null;
    }

    private function test(Warehouse $warehouse): void
    {
        $products = $this->productRepository->findBy(['warehouse' => $warehouse]);

        $url = 0;

    }
}