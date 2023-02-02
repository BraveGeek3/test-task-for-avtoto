<?php

namespace App\Tests\Utils;

use App\Clients\Domain\ValueObject\CreateClientRequest;
use App\Shared\Infrastructure\Service\Identifier\IdentifierService;
use Faker\Factory;
use Faker\Generator;

trait FakerUtil
{
    public static function getFaker(): Generator
    {
        return Factory::create('ru_RU');
    }

    public static function createFakeAddressData(): array
    {
        $faker = self::getFaker();

        $region = $faker->region() . ' ' . $faker->regionSuffix();
        $city = $faker->city();
        $street = $faker->street();
        $buildingNumber = $faker->buildingNumber();

        return [
            'region' => $region,
            'city' => $city,
            'street' => $street,
            'buildingNumber' => $buildingNumber
        ];
    }

    public static function createFakeProductsData(int $productsCount = 5): array
    {
        $result = [];
        for ($i = 0; $i < $productsCount; ++$i) {
            $result[] = [
                'id' => IdentifierService::generate(),
                'availableCount' => rand(1, 10)
            ];
        }

        return $result;
    }

    public static function createFakeProductsDataForOrder(int $productsCount = 5): array
    {
        $result = [];
        for ($i = 0; $i < $productsCount; ++$i) {
            $result[] = [
                'id' => IdentifierService::generate(),
                'count' => rand(1, 10)
            ];
        }

        return $result;
    }

    public function createFakeClientData(): array
    {
        $faker = self::getFaker();

        return  [
            'email' => $faker->email(),
            'firstName' => $faker->firstName(),
            'lastName' => $faker->lastName(),
            'patronymic' => $faker->name(),
            'phoneNumber' => $faker->phoneNumber(),
        ];
    }

    public static function createFakeCreateProductsData(): array
    {
        $faker = self::getFaker();

        $title = $faker->title();
        $price = $faker->randomFloat(1, 10, 1000);
        $availableCount = $faker->randomDigit();
        $warehouseId = IdentifierService::generate();

        return [
            'title' => $title,
            'price' => $price,
            'availableCount' => $availableCount,
            'warehouseId' => $warehouseId
        ];
    }
}