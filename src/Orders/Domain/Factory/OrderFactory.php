<?php

namespace App\Orders\Domain\Factory;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Factory\ClientFactory;
use App\Clients\Domain\ValueObject\CreateClientRequest;
use App\Orders\Domain\Entity\Order;
use App\Shared\Domain\Factory\AddressFactory;
use App\Shared\Domain\ValueObject\CreateAddress;
use App\Shared\Infrastructure\Service\Identifier\IdentifierService;

class OrderFactory
{
    public static function create(array $data, ?Client $client, bool $isCityEqual = false): Order
    {
        $order = new Order();
        $addressDto = CreateAddress::createFromRequest($data['address']);
        $address = AddressFactory::create($addressDto);

        $order->setStatus(Order::STATUSES['WAITING_FOR_PROCESSING']);
        $order->setAddress($address);

        if ($client === null) {
            $clientDto = CreateClientRequest::createFromeRequest($data['client']);
            $client = ClientFactory::create($clientDto);
        }

        $order->setClient($client);

        $order
            ->setTransportCompanyId(null)
            ->setDeliveryPrice(null);

        if ($isCityEqual) {
            $order
                ->setDeliveryPrice(0)
                ->setStatus(Order::STATUSES['WAITING_TO_DISPATCH'])
//                нужно ли?
                ->setTransportCompanyId(IdentifierService::generate());
        }

        return $order;
    }

}