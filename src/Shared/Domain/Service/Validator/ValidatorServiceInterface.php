<?php

namespace App\Shared\Domain\Service\Validator;

interface ValidatorServiceInterface
{
    public function validate(array $data): bool;

}