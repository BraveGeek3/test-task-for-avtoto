<?php

namespace App\Clients\Domain\ValueObject;

use InvalidArgumentException;

class CreateClientRequest
{
    private string $email;
    private string $firstName;
    private string $lastName;
    private ?string $patronymic;
    private string $phoneNumber;

    private function __construct(
        string $email,
        string $firstName,
        string $lastName,
        string $phoneNumber,
        ?string $patronymic = null
    )
    {
        $this->email = $email;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phoneNumber = $phoneNumber;
        $this->patronymic = $patronymic;
    }

    /**
     * @param array $data
     * @return $this
     */
    public static function createFromeRequest(array $data): self
    {
        $properties = (new \ReflectionClass(self::class))->getProperties();
        foreach ($properties as $property) {
            if ($property->getType()->allowsNull()) {
                continue;
            }

            $propValue = $property->getName();
            if (!isset($data[$propValue])) {
                throw new InvalidArgumentException("$propValue field is missing");
            }
        }

        return new self($data['email'], $data['firstName'], $data['lastName'], $data['phoneNumber'], $data['patronymic'] ?? null);
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

}