<?php

namespace App\Tests\Warehouses\Domain\Factory;

use App\Products\Domain\Factory\ProductFactory;
use App\Products\Domain\ValueObject\CreateProductRequest;
use App\Tests\Utils\FakerUtil;
use App\Warehouses\Domain\Factory\WarehouseFactory;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class WarehouseFactoryTest extends WebTestCase
{
    use FakerUtil;

    public function test_warehouse_created_successfully(): void
    {
        $productsCount = rand(1, 5);

        $addressData = $this->createFakeAddressData();

        $products = [];
        foreach (range(0, $productsCount) as $idx) {
            $productsDatum = $this->createFakeCreateProductsData();
            $dto = CreateProductRequest::createFromRequest($productsDatum);

            $products[] = ProductFactory::create($dto);
        }


        $warehouse = WarehouseFactory::create($addressData, $products);

        $warehouseAddress = $warehouse->getAddress();

        $this->assertEquals($addressData,[
            'region' => $warehouseAddress->getRegion(),
            'city' => $warehouseAddress->getCity(),
            'street' => $warehouseAddress->getStreet(),
            'buildingNumber' => $warehouseAddress->getBuildingNumber()
        ]);
    }
}