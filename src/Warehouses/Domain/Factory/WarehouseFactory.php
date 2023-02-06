<?php

namespace App\Warehouses\Domain\Factory;

use App\Shared\Domain\Factory\AddressFactory;
use App\Shared\Domain\ValueObject\CreateAddress;
use App\Warehouses\Domain\Entity\Warehouse;

class WarehouseFactory
{
    public static function create(CreateAddress $addressDto): Warehouse
    {
        $warehouse = new Warehouse();

        $address = AddressFactory::createForWarehouse($addressDto);
        $warehouse
            ->setAddress($address);

//        foreach ($products as $product) {
//            $warehouse->addProduct($product);
//        }

        return $warehouse;
    }
}