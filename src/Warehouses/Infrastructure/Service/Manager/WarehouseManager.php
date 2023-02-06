<?php

namespace App\Warehouses\Infrastructure\Service\Manager;

use App\Products\Infrastructure\Repository\ProductRepository;
use App\Shared\Domain\ValueObject\CreateAddress;
use App\Shared\Infrastructure\Repository\Address\AddressRepository;
use App\Warehouses\Domain\Entity\Warehouse;
use App\Warehouses\Domain\Factory\WarehouseFactory;
use App\Warehouses\Infrastructure\Repository\WarehouseRepository;
use InvalidArgumentException;

class WarehouseManager
{
    private WarehouseRepository $warehouseRepository;
    private AddressRepository $addressRepository;

    public function __construct(
        WarehouseRepository $warehouseRepository,
        AddressRepository $addressRepository
    )
    {
        $this->warehouseRepository = $warehouseRepository;
        $this->addressRepository = $addressRepository;
    }

    public function removeWarehouse(array $data): ?string
    {
        if (!isset($data['warehouseId'])) {
            throw new InvalidArgumentException("warehouseId is missing");
        }

        if (($warehouse = $this->warehouseRepository->findById($data['warehouseId'])) === null) {
            throw new InvalidArgumentException("Provide correct warehouseId");
        }

        $warehouseId = $warehouse->getId();
        $this->warehouseRepository->remove($warehouse);

        return $warehouseId;
    }

    public function showInfo(string $warehouseId): ?Warehouse
    {
        $warehouse = $this->warehouseRepository->findById($warehouseId);
        if ($warehouse === null) {
            throw new InvalidArgumentException("Provide correct warehouse id");
        }

        return $warehouse;
    }

    public function addWarehouse(array $data): ?Warehouse
    {
        $addWarehouseDto = CreateAddress::createFromRequest($data);
        if ($this->isExists($addWarehouseDto)) {
            throw new InvalidArgumentException("There is already a warehouse at the selected address");
        }

        $warehouse = WarehouseFactory::create($addWarehouseDto);

        $this->warehouseRepository->save($warehouse);

        return $warehouse;
    }

    /**
     * @param array $address
     * @return bool
     */
    private function isExists(CreateAddress $address): bool
    {
        $result = $this->addressRepository->findByFullAddress($address, 'Склад');

        return isset($result);
    }
}