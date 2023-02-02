<?php

namespace App\Shared\Infrastructure\Repository\Address;

use App\Shared\Domain\Entity\Address\Address;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class AddressRepository extends ServiceEntityRepository
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Address::class);
    }

    public function findByFullAddress(array $addressData, string $type = 'Доставка'): ?Address
    {
        return parent::findOneBy([
            'region' => $addressData['region'],
            'city' => $addressData['city'],
            'street' => $addressData['street'],
            'buildingNumber' => $addressData['buildingNumber'],
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