<?php

namespace App\Products\Domain\ValueObject;

class CreateProductRequest
{
    private string $title;
    private float $price;
    private int $availableCount;
    private string $warehouseId;

    private function __construct(
        string $title,
        float $price,
        int $availableCount,
        string $warehouseId
    )
    {
        $this->title = $title;
        $this->price = $price;
        $this->availableCount = $availableCount;
        $this->warehouseId = $warehouseId;
    }

    /**
     * @param array $data
     * @return static
     */
    public static function createFromRequest(array $data): self
    {
        $properties = (new \ReflectionClass(self::class))->getProperties();
        foreach ($properties as $property) {
            if ($property->getType()->allowsNull()) {
                continue;
            }

            $propValue = $property->getName();
            if (!isset($data[$propValue])) {
                throw new \InvalidArgumentException("$propValue field is missing");
            }
        }

        return new self($data['title'], (float) $data['price'], (int) $data['availableCount'], $data['warehouseId']);
    }

    /**
     * @return string
     */
    public function getTitle(): string
    {
        return $this->title;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @return int
     */
    public function getAvailableCount(): int
    {
        return $this->availableCount;
    }

    /**
     * @return string|null
     */
    public function getWarehouseId(): ?string
    {
        return $this->warehouseId;
    }

}