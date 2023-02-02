<?php

namespace App\Clients\Domain\Factory;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Service\ClientValidatorService;
use App\Clients\Domain\ValueObject\CreateClientRequest;

class ClientFactory
{
    public static function create(CreateClientRequest $dto): ?Client
    {
        $client = new Client();

        $client
            ->setEmail($dto->getEmail())
            ->setFirstName($dto->getFirstName())
            ->setLastName($dto->getLastName())
            ->setPatronymic($dto->getPatronymic())
            ->setPhoneNumber($dto->getPhoneNumber());
        ;

        return $client;
    }
}