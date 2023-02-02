<?php

namespace App\Orders\Domain\ValueObject;

use App\Shared\Infrastructure\Service\Identifier\IdentifierService;
use InvalidArgumentException;

class TCDataRequest
{
    private string $orderId;
    private string $transportCompanyId;
    private float $deliveryPrice;

    private const REQUIRED_FIELDS = [
        'orderId',
        'transportCompanyId',
        'deliveryPrice'
    ];

    private function __construct(
        string $orderId,
        string $transportCompanyId,
        float $deliveryPrice
    )
    {
        $this->orderId = $orderId;
        $this->transportCompanyId = $transportCompanyId;
        $this->deliveryPrice = $deliveryPrice;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function createFromRequest(array $data): self
    {
        $properties = (new \ReflectionClass(self::class))->getProperties();
        foreach ($properties as $property) {
            $propValue = $property->getName();
            if (!isset($data[$propValue])) {
                throw new \InvalidArgumentException("$propValue field is missing");
            }
        }

        if (!IdentifierService::isValid($data['orderId'])) {
            throw new InvalidArgumentException(["Invalid order id"]);
        }

        return new self($data['orderId'], $data['transportCompanyId'], $data['deliveryPrice']);
    }

    /**
     * @return string
     */
    public function getOrderId(): string
    {
        return $this->orderId;
    }

    /**
     * @return string
     */
    public function getTransportCompanyId(): string
    {
        return $this->transportCompanyId;
    }

    /**
     * @return float
     */
    public function getDeliveryPrice(): float
    {
        return $this->deliveryPrice;
    }
}