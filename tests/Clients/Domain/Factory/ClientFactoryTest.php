<?php

namespace App\Tests\Clients\Domain\Factory;

use App\Clients\Domain\Factory\ClientFactory;
use App\Clients\Domain\ValueObject\CreateClientRequest;
use App\Tests\Utils\FakerUtil;
use Faker\Generator;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class ClientFactoryTest extends WebTestCase
{
    use FakerUtil;

    public function test_client_created_successfully(): void
    {
        $clientData = $this->createFakeClientData();
        $dto = CreateClientRequest::createFromeRequest($clientData);

        $client = ClientFactory::create($dto);

        $this->assertEquals($clientData, [
            'email' => $client->getEmail(),
            'firstName' => $client->getFirstName(),
            'lastName' => $client->getLastName(),
            'patronymic' => $client->getPatronymic(),
            'phoneNumber' => $client->getPhoneNumber(),
        ]);
    }

}