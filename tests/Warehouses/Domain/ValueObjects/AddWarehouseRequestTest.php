<?php

namespace App\Tests\Warehouses\Domain\ValueObjects;

use App\Tests\Utils\FakerUtil;
use App\Warehouses\Domain\ValueObject\AddWarehouseRequest;
use Faker\Generator;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddWarehouseRequestTest extends WebTestCase
{
    use FakerUtil;

    public function test_dto_with_products_created_successfully(): void
    {
        $productCount = rand(1, 10);

        $address = $this->createFakeAddressData();
        $products = $this->createFakeProductsData($productCount);

        $dto = AddWarehouseRequest::createFromRequest([
            'address' => $address,
            'products' => $products,
        ]);

        $this->assertEquals($address, $dto->getAddress());
        $this->assertEquals($products, $dto->getProducts());
        $this->assertEquals($productCount, \count($dto->getProducts()));
    }

    public function test_dto_without_products_created_successfully(): void
    {
        $address = $this->createFakeAddressData();

        $dto = AddWarehouseRequest::createFromRequest([
            'address' => $address
        ]);

        $this->assertEquals($address, $dto->getAddress());
        $this->assertEquals([], $dto->getProducts());
    }

    public function test_dto_with_empty_fields_throw_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dto = AddWarehouseRequest::createFromRequest([]);
    }

}