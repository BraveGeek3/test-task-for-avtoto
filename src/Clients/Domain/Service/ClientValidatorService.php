<?php

namespace App\Clients\Domain\Service;

use App\Clients\Domain\Entity\Client;

class ClientValidatorService
{
    protected const EXCLUDED_FIELDS = [
        'id',
        'patronymic'
    ];

    /**
     * @param array $data
     * @param Client $client
     * @return bool
     */
    public static function isFieldsValid(array $data): bool
    {
        foreach (self::getRequiredFields() as $property) {
            $name = $property->getName();
            if (in_array($name, self::EXCLUDED_FIELDS)) {
                continue;
            }

            if (!isset($data[$name]) || empty($data[$name])) {
                return false;
            }
        }

        return true;
    }


    public static function getRequiredFields(): array
    {
        return (new \ReflectionClass(new Client()))->getProperties();
    }

}