<?php

namespace App\Products\Infrastructure\Service\Validator;

use App\Shared\Domain\Service\Validator\ValidatorServiceInterface;

class ProductValidatorService implements ValidatorServiceInterface
{

    public function validate(array $data): bool
    {
        return true;
    }
}