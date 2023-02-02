<?php

namespace App\Clients\Infrastructure\Service\Manager;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Factory\ClientFactory;
use App\Clients\Domain\ValueObject\CreateClientRequest;
use App\Clients\Infrastructure\Repository\ClientRepository;
use InvalidArgumentException;

class ClientManagerService
{
    private ClientRepository $clientRepository;

    public function __construct(
        ClientRepository $clientRepository
    )
    {
        $this->clientRepository = $clientRepository;
    }

    /**
     * @param array $data
     * @return Client|null
     */
    public function createClient(array $data): ?Client
    {
        $createClientDto = CreateClientRequest::createFromeRequest($data);
        if ($this->isExists($createClientDto->getEmail(), $createClientDto->getPhoneNumber())) {
            throw new InvalidArgumentException("User with this email and phone number already exist");
        }

        $client = ClientFactory::create($createClientDto);

        $this->clientRepository->save($client);

        return $client;
    }

    /**
     * @param string $email
     * @param string $phoneNumber
     * @return bool
     */
    private function isExists(string $email, string $phoneNumber): bool
    {
        if (
            null !== $this->clientRepository->findByEmail($email) ||
            null !== $this->clientRepository->findByPhoneNumber($phoneNumber)
        )
            return true;

        return false;
    }
}