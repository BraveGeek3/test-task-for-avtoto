<?php

namespace App\Orders\Domain\Entity;

use App\Clients\Domain\Entity\Client;
use App\Shared\Domain\Entity\Address\Address;
use App\Shared\Domain\Entity\EntityInterface;
use App\Shared\Infrastructure\Service\Identifier\IdentifierService;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;

class Order implements EntityInterface
{

    private $id;

    private ?string $transportCompanyId;

    private DateTime $createdAt;

    private string $status;

    private ?float $deliveryPrice;

    private ?Client $client;

    private Collection $products;

    private ?Address $address;

    public const STATUSES = [
        'WAITING_FOR_PROCESSING' => 'Ожидает обработки',
        'WAITING_TO_DISPATCH' => 'Ожидает отправки',
        'SENT' => 'Отправлено',
        'ISSUED_TO_CLIENT' => 'Выдано клиенту',
    ];

    public function __construct()
    {
        $this->id = IdentifierService::generate();
        $this->status = self::STATUSES['WAITING_FOR_PROCESSING'];
        $this->transportCompanyId = null;
        $this->createdAt = new DateTime();
        $this->deliveryPrice = null;
        $this->products = new ArrayCollection();
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
    public function getTransportCompanyId(): string
    {
        return $this->transportCompanyId;
    }

    /**
     * @param string $transportCompanyId
     */
    public function setTransportCompanyId(string $transportCompanyId): self
    {
        $this->transportCompanyId = $transportCompanyId;

        return $this;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

//    /**
//     * @param DateTime $createdAt
//     */
//    public function setCreatedAt(DateTime $createdAt): void
//    {
//        $this->createdAt = $createdAt;
//    }

    /**
     * @return string
     */
    public function getStatus(): string
    {
        return $this->status;
    }

    /**
     * @param string $status
     */
    public function setStatus(string $status): self
    {
        $this->status = $status;

        return $this;
    }

    /**
     * @return float|null
     */
    public function getDeliveryPrice(): ?float
    {
        return $this->deliveryPrice;
    }

    /**
     * @param float|null $deliveryPrice
     */
    public function setDeliveryPrice(?float $deliveryPrice): self
    {
        $this->deliveryPrice = $deliveryPrice;

        return $this;
    }

    /**
     * @return Client|null
     */
    public function getClient(): ?Client
    {
        return $this->client;
    }

    /**
     * @param Client|null $client
     * @return $this
     */
    public function setClient(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getProducts()
    {
        return $this->products;
    }

    /**
     * @param mixed $products
     */
    public function setProducts(array $ordersProductsRelations): self
    {
        foreach ($ordersProductsRelations as $ordersProductRelation) {
            $this->addProductRelation($ordersProductRelation);
        }

        return $this;
    }

    public function addProductRelation(OrdersProducts $ordersProductRelation): self
    {
        if (!$this->products->contains($ordersProductRelation)) {
            $this->products->add($ordersProductRelation);
            $ordersProductRelation->setOrder($this);
        }

        return $this;
    }

    /**
     * @return Address|null
     */
    public function getAddress(): ?Address
    {
        return $this->address;
    }

    /**
     * @param Address|null $address
     * @return void
     */
    public function setAddress(?Address $address): void
    {
        $this->address = $address;
    }

}