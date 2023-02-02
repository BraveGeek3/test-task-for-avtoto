<?php

namespace App\Tests\Orders\Domain\ValueObject;

use App\Orders\Domain\ValueObject\CreateOrderRequest;
use App\Tests\Utils\FakerUtil;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateOrderRequestTest extends WebTestCase
{
    use FakerUtil;
    public function test_dto_created_successfully(): void
    {
        $clientData = $this->createFakeClientData();
        $addressData = $this->createFakeAddressData();
        $productsData = $this->createFakeProductsDataForOrder(5);
        $dto = CreateOrderRequest::createFromRequest([
            'address' => $addressData,
            'client' => $clientData,
            'products' => $productsData
        ]);

        $this->assertEquals($addressData, $dto->getAddress());
        $this->assertEquals($clientData, $dto->getClient());
        $this->assertEquals($productsData, $dto->getProducts());
    }

    public function test_dto_empty_data_throw_exception(): void
    {
        $this->expectException(InvalidArgumentException::class);
        $dto = CreateOrderRequest::createFromRequest([]);
    }

}