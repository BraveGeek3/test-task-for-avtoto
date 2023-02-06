<?php

namespace App\Shared\Infrastructure\Repository\Address;

use App\Shared\Domain\Entity\Address\Address;
use App\Shared\Domain\ValueObject\CreateAddress;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function findByFullAddress(CreateAddress $addressDto, string $type = 'Доставка'): ?Address
    {
        return parent::findOneBy([
            'region' => $addressDto->getRegion(),
            'city' => $addressDto->getCity(),
            'street' => $addressDto->getStreet(),
            'buildingNumber' => $addressDto->getBuildingNumber(),
            'type' => $type
        ]);
    }

    public function findAllByCity(string $city): array
    {
        return parent::findBy([
            'city' => $city,
            'type' => 'Склад',
        ]);
    }
}