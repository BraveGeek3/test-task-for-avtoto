<?php

namespace App\Shared\Domain\Factory;

use App\Shared\Domain\Entity\Address\Address;
use App\Shared\Domain\ValueObject\CreateAddress;

class AddressFactory
{
    public static function create(CreateAddress $dto): Address
    {
        $address = new Address();
        $address
            ->setRegion($dto->getRegion())
            ->setCity($dto->getCity())
            ->setStreet($dto->getStreet())
            ->setBuildingNumber($dto->getBuildingNumber())
        ;

        return $address;
    }

    public static function createForWarehouse(CreateAddress $dto): Address
    {
        $address = self::create($dto);
        $address->setType('Склад');

        return $address;
    }

}