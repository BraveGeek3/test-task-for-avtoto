<?php

namespace App\Tests\Clients\Domain\ValueObject;

use App\Clients\Domain\ValueObject\CreateClientRequest;
use App\Tests\Utils\FakerUtil;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;

class CreateClientRequestTest extends WebTestCase
{
    use FakerUtil;

    public function test_create_client_request_dto_created_successfully(): void
    {
        $clientData = $this->createFakeClientData();
        $dto = CreateClientRequest::createFromeRequest($clientData);

        $this->assertEquals($clientData, [
            'email' => $dto->getEmail(),
            'firstName' => $dto->getFirstName(),
            'lastName' => $dto->getLastName(),
            'patronymic' => $dto->getPatronymic(),
            'phoneNumber' => $dto->getPhoneNumber(),
        ]);
    }
}