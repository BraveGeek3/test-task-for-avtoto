<?php

namespace App\Shared\Domain\ValueObject;


class CreateAddress
{
    private string $region;
    private string $city;
    private string $street;
    private string $buildingNumber;

    private function __construct(
        string $region,
        string $city,
        string $street,
        string $buildingNumber
    )
    {
        $this->region = $region;
        $this->city = $city;
        $this->street = $street;
        $this->buildingNumber = $buildingNumber;
    }

    public static function createFromRequest(array $data): self
    {
        $properties = (new \ReflectionClass(self::class))->getProperties();
        foreach ($properties as $property) {
            $propValue = $property->getName();
            if (!isset($data[$propValue])) {
                throw new \InvalidArgumentException("$propValue field is missing");
            }
        }

        return new self($data['region'], $data['city'], $data['street'], $data['buildingNumber']);
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }


    /**
     * @return string
     */
    public function getRegion(): string
    {
        return $this->region;
    }

    /**
     * @return string
     */
    public function getCity(): string
    {
        return $this->city;
    }

    /**
     * @return string
     */
    public function getStreet(): string
    {
        return $this->street;
    }

    /**
     * @return string
     */
    public function getBuildingNumber(): string
    {
        return $this->buildingNumber;
    }
}