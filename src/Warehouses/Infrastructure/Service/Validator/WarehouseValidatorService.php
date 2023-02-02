<?php

namespace App\Warehouses\Infrastructure\Service\Validator;

use App\Shared\Domain\Service\Validator\ValidatorServiceInterface;

class WarehouseValidatorService implements ValidatorServiceInterface
{

    public function validate(array $data): bool
    {
        return true;
    }
}