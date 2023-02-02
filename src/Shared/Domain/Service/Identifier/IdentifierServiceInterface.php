<?php

namespace App\Shared\Domain\Service\Identifier;

interface IdentifierServiceInterface
{
    public static function generate(): string;
    public static function isValid(string $id): bool;
}