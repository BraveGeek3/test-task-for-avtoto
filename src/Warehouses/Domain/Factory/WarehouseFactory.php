<?php

namespace App\Warehouses\Domain\Factory;

use App\Shared\Domain\Factory\AddressFactory;
use App\Shared\Domain\ValueObject\CreateAddress;
use App\Warehouses\Domain\Entity\Warehouse;

class WarehouseFactory
{
    public static function create(array $addressData, array $products): Warehouse
    {
        $warehouse = new Warehouse();

        //TODO: поменять на DTO
        $addressDto = CreateAddress::createFromRequest($addressData);
        $address = AddressFactory::createForWarehouse($addressDto);
        $warehouse
            ->setAddress($address);

        foreach ($products as $product) {
            $warehouse->addProduct($product);
        }

        return $warehouse;
    }
}