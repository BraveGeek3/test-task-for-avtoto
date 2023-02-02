<?php

namespace App\Clients\Domain\Repository;

use App\Clients\Domain\Entity\Client;
use App\Shared\Domain\Repository\RepositoryInterface;

interface ClientRepositoryInterface extends RepositoryInterface
{
    public function findByEmail(string $email): ?Client;
    public function findByEmailAndPhoneNumber(string $email, string $phoneNumber): ?Client;
    public function findByPhoneNumber(string $phoneNumber): ?Client;
}