<?php

namespace App\Tests\Shared\Domain\Factory;

use App\Shared\Domain\Factory\AddressFactory;
use App\Shared\Domain\ValueObject\CreateAddress;
use App\Tests\Utils\FakerUtil;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class AddressFactoryTest extends WebTestCase
{
    use FakerUtil;

    public function test_address_created_successfully(): void
    {
        $addressData = $this->createFakeAddressData();
        $dto = CreateAddress::createFromRequest($addressData);
        $address = AddressFactory::create($dto);

        $this->assertEquals($addressData, [
            'region' => $address->getRegion(),
            'city' => $address->getCity(),
            'street' => $address->getStreet(),
            'buildingNumber' => $address->getBuildingNumber()
        ]);
    }

}