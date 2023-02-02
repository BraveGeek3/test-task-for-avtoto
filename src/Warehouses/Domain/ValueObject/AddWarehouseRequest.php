<?php

namespace App\Warehouses\Domain\ValueObject;

use InvalidArgumentException;

class AddWarehouseRequest
{
    private array $address;
    private array $products;

    private const ADDRESS_REQUIRED_FIELDS = [
        'address' => [
            'region',
            'city',
            'street',
            'buildingNumber'
        ]
    ];
    private function __construct(
        array $address,
        array $products
    )
    {
        $this->address = $address;
        $this->products = $products;

    }

    /**
     * @param array $data
     * @return static
     */
    public static function createFromRequest(array $data): self
    {
        foreach (self::ADDRESS_REQUIRED_FIELDS as $mainFiled => $subFields) {
            foreach ($subFields as $field) {
                if (!isset($data[$mainFiled][$field])) {
                    throw new InvalidArgumentException("[$mainFiled][$field] is missing");
                }
            }
        }

        if (isset($data['products'])) {
            foreach ($data['products'] as $product) {
                if (empty($product['id']) || empty($product['availableCount'])) {
                    throw new InvalidArgumentException("Product fields are missing");
                }
            }
        }

        return new self($data['address'], $data['products'] ?? []);
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