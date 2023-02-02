<?php

namespace App\Orders\Infrastructure\Repository;

use App\Orders\Domain\Entity\Order;
use App\Orders\Domain\Repository\OrderRepositoryInterface;
use App\Shared\Domain\Entity\EntityInterface;
use Doctrine\Bundle\DoctrineBundle\Repository\ServiceEntityRepository;
use Doctrine\Persistence\ManagerRegistry;

class OrderRepository extends ServiceEntityRepository implements OrderRepositoryInterface
{
    public function __construct(ManagerRegistry $registry)
    {
        parent::__construct($registry, Order::class);
    }

    public function save(EntityInterface $order): void
    {
        $this->_em->persist($order);
        $this->_em->flush();
    }

    public function remove(EntityInterface $order): void
    {
        $this->_em->remove($order);
        $this->_em->flush();
    }

    public function findByTransportCompanyId(int $transportCompanyId): ?Order
    {
        return parent::findOneBy(['transportCompanyId' => $transportCompanyId]);
    }

    public function findById(string $id): ?Order
    {
        return parent::findOneBy(['id' => $id]);
    }
}