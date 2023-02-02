<?php

namespace App\Orders\Infrastructure\Service\Validator;

use App\Shared\Domain\Service\Validator\ValidatorServiceInterface;

class OrderValidatorService implements ValidatorServiceInterface
{
    public function validate(array $data): bool
    {
        // TODO: сделать валидацию через бандл
        return true;
    }
}