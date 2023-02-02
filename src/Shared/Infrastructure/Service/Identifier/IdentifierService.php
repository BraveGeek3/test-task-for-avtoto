<?php

namespace App\Shared\Infrastructure\Service\Identifier;

use App\Shared\Domain\Service\Identifier\IdentifierServiceInterface;
use Symfony\Component\Uid\Ulid;

class IdentifierService implements IdentifierServiceInterface
{
    public static function generate(): string
    {
        return Ulid::generate();
    }

    public static function isValid(string $id): bool
    {
        return Ulid::isValid($id);
    }
}