<?php

namespace App\Clients\Domain\Entity;

use App\Shared\Domain\Entity\Address\Address;
use App\Shared\Domain\Entity\EntityInterface;
use App\Shared\Infrastructure\Service\Identifier\IdentifierService;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Client implements EntityInterface
{
    private $id;
    private string $firstName;
    private string $lastName;
    private ?string $patronymic;
    private string $email;
    private string $phoneNumber;

    private Collection $orders;

    public function __construct()
    {
        $this->id = IdentifierService::generate();
        $this->firstName = '';
        $this->lastName = '';
        $this->email = '';
        $this->patronymic = null;
        $this->orders = new ArrayCollection();
        $this->phoneNumber = '';

        return $this;
    }

    /**
     * @return string
     */
    public function getPhoneNumber(): string
    {
        return $this->phoneNumber;
    }

    /**
     * @param string $phoneNumber
     */
    public function setPhoneNumber(string $phoneNumber): void
    {
        $this->phoneNumber = $phoneNumber;
    }

    /**
     * @return Collection
     */
    public function getOrders(): Collection
    {
        return $this->orders;
    }

    /**
     * @param Collection $orders
     */
    public function setOrders(Collection $orders): void
    {
        $this->orders = $orders;
    }


    /**
     * @return string
     */
    public function getId(): string
    {
        return $this->id;
    }

    /**
     * @param string $id
     */
//    public function setId(string $id): void
//    {
//        $this->id = $id;
//    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @param string $firstName
     */
    public function setFirstName(string $firstName): self
    {
        $this->firstName = $firstName;

        return $this;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @param string $lastName
     */
    public function setLastName(string $lastName): self
    {
        $this->lastName = $lastName;

        return $this;
    }

    /**
     * @return string|null
     */
    public function getPatronymic(): ?string
    {
        return $this->patronymic;
    }

    /**
     * @param string|null $patronymic
     */
    public function setPatronymic(?string $patronymic): self
    {
        $this->patronymic = $patronymic;

        return $this;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Address|null
     */
//    public function getDeliveryAddress(): ?Address
//    {
//        return $this->deliveryAddress;
//    }

//    public function getDeliveryAddress(): string
//    {
//        return $this->deliveryAddress;
//    }

//    /**
//     * @param Address|null $deliveryAddress
//     */
//    public function setDeliveryAddress(?Address $deliveryAddress): self
//    {
//        $this->deliveryAddress = $deliveryAddress;
//
//        return $this;
//    }

//    public function setDeliveryAddress(string $deliveryAddress): self
//    {
//        $this->deliveryAddress = $deliveryAddress;
//
//        return $this;
//    }
}