<?php

namespace App\Orders\Infrastructure\Service\Manager;

use App\Clients\Domain\Entity\Client;
use App\Clients\Infrastructure\Repository\ClientRepository;
use App\Orders\Domain\Entity\Order;
use App\Orders\Domain\Entity\OrdersProducts;
use App\Orders\Domain\Factory\OrderFactory;
use App\Orders\Domain\ValueObject\CreateOrderRequest;
use App\Orders\Domain\ValueObject\TCDataRequest;
use App\Orders\Infrastructure\Repository\OrderRepository;
use App\Products\Infrastructure\Repository\ProductRepository;
use App\Shared\Infrastructure\Repository\Address\AddressRepository;
use InvalidArgumentException;

class OrderManager
{
    private OrderRepository $orderRepository;
    private ProductRepository $productRepository;
    private ClientRepository $clientRepository;
    private AddressRepository $addressRepository;

    public function __construct(
        OrderRepository $orderRepository,
        ProductRepository $productRepository,
        ClientRepository $clientRepository,
        AddressRepository $addressRepository
    )
    {
        $this->orderRepository = $orderRepository;
        $this->productRepository = $productRepository;
        $this->clientRepository = $clientRepository;
        $this->addressRepository = $addressRepository;
    }

    public function removeOrder(array $data): ?Order
    {
        if (!isset($data['orderId'])) {
            throw new InvalidArgumentException("orderId is missing");
        }

        $order = $this->orderRepository->findById($data['orderId']);
        $order->setClient(null);
        $order->setAddress(null);

        $this->orderRepository->remove($order);

        return $order;
    }

    public function addTransportCompanyData(array $data): ?Order
    {
        $TCDataDto = TCDataRequest::createFromRequest($data);

        if (($order = $this->orderRepository->findById($TCDataDto->getOrderId())) === null) {
            throw new InvalidArgumentException("Invalid order id");
        }

        $order
            ->setTransportCompanyId($TCDataDto->getTransportCompanyId())
            ->setDeliveryPrice($TCDataDto->getDeliveryPrice())
        ;

        $this->orderRepository->save($order);

        return $order;
    }

    /**
     * @param array $data
     * @return Order|null
     * @throws \Exception
     */
    public function processOrder(array $data): ?Order
    {
        $createOrderDto = CreateOrderRequest::createFromRequest($data);

        $addressData = $createOrderDto->getAddress();
        $clientData = $createOrderDto->getClient();
        $productsData = $createOrderDto->getProducts();

        $clientCity= $addressData['city'];
        $client = $this->getClient($clientData['email'], $clientData['phoneNumber']);

        $products = $this->getProducts($productsData);

        $isCitiesEqual = $this->isCitiesEqual($clientCity, $products);

        $order = OrderFactory::create($data, $client, $isCitiesEqual);

        foreach ($products as $idx => $product) {
            $ordersProductRelation = new OrdersProducts();
            $ordersProductRelation->setProduct($product);
            $ordersProductRelation->setOrderedCount($productsData[$idx]['count']);

            $order->addProductRelation($ordersProductRelation);
        }

        $this->orderRepository->save($order);

        return $order;
    }

    /**
     * @param string $clientCity
     * @param array $products
     * @return bool
     */
    private function isCitiesEqual(string $clientCity, array $products): bool
    {
        foreach ($products as $product) {
            $warehouse = $product->getWarehouse();
            if ($warehouse->getAddress()->getCity() !== $clientCity) {
                return false;
            }
        }

        return true;
    }

    /**
     * @param array $productsData
     * @return array
     */
    private function getProducts(array $productsData): array
    {
        $result = [];
        foreach ($productsData as $idx => $productsDatum) {
            $product =  $this->productRepository->findById($productsDatum['id']);
            if ($product === null) {
                throw new InvalidArgumentException("Non-existent product[$idx] id");
            }

            if ($productsDatum['count'] > $product->getAvailableCount()) {
                throw new InvalidArgumentException("Required product count is higher then available count");
            }

            $result[] = $product;
        }

        return $result;
    }

    /**
     * @param string $email
     * @param string $phoneNumber
     * @return Client|null
     */
    private function getClient(string $email, string $phoneNumber): ?Client
    {
        return $this->clientRepository->findByEmailAndPhoneNumber($email, $phoneNumber);
    }
}