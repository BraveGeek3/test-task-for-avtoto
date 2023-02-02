<?php

namespace App\Clients\Infrastructure\Repository;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Repository\ClientRepositoryInterface;
use App\Shared\Domain\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class ClientRepository extends ServiceEntityRepository implements ClientRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Client::class);
    }

    public function save(EntityInterface $client): void
    {
        $this->_em->persist($client);
        $this->_em->flush();
    }

    public function remove(EntityInterface $client): void
    {
        $this->_em->remove($client);
        $this->_em->flush();
    }

    public function findByEmail(string $email): ?Client
    {
        return parent::findOneBy(['email' => $email]);
    }

    public function findByEmailAndPhoneNumber(string $email, string $phoneNumber): ?Client
    {
        return parent::findOneBy([
            'phoneNumber' => $phoneNumber,
            'email' => $email,
        ]);
    }

    public function findByPhoneNumber(string $phoneNumber): ?Client
    {
        return parent::findOneBy([
            'phoneNumber' => $phoneNumber
        ]);
    }
}