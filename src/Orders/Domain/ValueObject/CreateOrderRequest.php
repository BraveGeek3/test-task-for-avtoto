<?php

namespace App\Orders\Domain\ValueObject;

use App\Shared\Infrastructure\Service\Identifier\IdentifierService;
use InvalidArgumentException;

class CreateOrderRequest
{
    private array $client;
    private array $address;
    private array $products;

    private const CLIENT_REQUIRED_FIELDS = [
        'client' => [
            'phoneNumber',
            'email',
            'firstName',
            'lastName',
            'patronymic',
        ],
        'address' => [
            'region',
            'city',
            'street',
            'buildingNumber',
        ],
//        'products' => [
//            'id',
//            'count'
//        ],
    ];

    private function __construct(
        array $client,
        array $address,
        array $products
    )
    {
        $this->client = $client;
        $this->address = $address;
        $this->products = $products;
    }

    public static function createFromRequest(array $data): self
    {
        foreach (self::CLIENT_REQUIRED_FIELDS as $fieldCategoryName => $fieldCategory) {
            foreach ($fieldCategory as $fieldValue) {
                if ($fieldValue === 'patronymic') {
                    continue;
                }

                if (!isset($data[$fieldCategoryName][$fieldValue])) {
                    throw new InvalidArgumentException("[$fieldCategoryName][$fieldValue] is missing");
                }
            }
        }

        foreach ($data['products'] as $idx => $productData) {
            if (!isset($productData['id']) || !isset($productData['count'])) {
                throw new InvalidArgumentException("Missed fields in product #$idx");
            }

            if (!IdentifierService::isValid($productData['id'])) {
                throw new InvalidArgumentException("Invalid product id");
            }
        }

        return new self($data['client'], $data['address'], $data['products']);
    }

    /**
     * @return array
     */
    public function getClient(): array
    {
        return $this->client;
    }

    /**
     * @return array
     */
    public function getAddress(): array
    {
        return $this->address;
    }

    /**
     * @return array
     */
    public function getProducts(): array
    {
        return $this->products;
    }

}