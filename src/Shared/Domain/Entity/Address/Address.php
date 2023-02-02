<?php

namespace App\Shared\Domain\Entity\Address;

use App\Shared\Domain\Entity\EntityInterface;
use App\Shared\Infrastructure\Service\Identifier\IdentifierService;
use InvalidArgumentException;

class Address implements EntityInterface
{
    private $id;
    private string $region;
    private string $city;
    private string $street;
    private string $buildingNumber;
    private string $type;

    private const ADDRESS_TYPES = [
        'WAREHOUSE' => 'Склад',
        'DELIVERY' => 'Доставка'
    ];

    public function __construct()
    {
        $this->id = IdentifierService::generate();
        $this->region = '';
        $this->city = '';
        $this->street = '';
        $this->buildingNumber = '';
        $this->type = self::ADDRESS_TYPES['DELIVERY'];

        return $this;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        if (!in_array($type, self::ADDRESS_TYPES)) {
            throw new InvalidArgumentException("Incorrect type for address");
        }

        $this->type = $type;
    }

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

//    /**
//     * @param mixed $id
//     */
//    public function setId($id): void
//    {
//        $this->id = $id;
//    }

    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @param string $region
     */
    public function setRegion(string $region): self
    {
        $this->region = $region;

        return $this;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @param string $city
     */
    public function setCity(string $city): self
    {
        $this->city = $city;

        return $this;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @param string $street
     */
    public function setStreet(string $street): self
    {
        $this->street = $street;

        return $this;
    }

    /**
     * @return string
     */
    public function getBuildingNumber(): string
    {
        return $this->buildingNumber;
    }

    /**
     * @param string $buildingNumber
     */
    public function setBuildingNumber(string $buildingNumber): self
    {
        $this->buildingNumber = $buildingNumber;

        return $this;
    }


}