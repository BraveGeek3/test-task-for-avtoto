<?php

namespace App\Orders\Infrastructure\Controller;

use App\Orders\Infrastructure\Service\Manager\OrderManager;
use App\Orders\Infrastructure\Service\Validator\OrderValidatorService;
use App\Orders\Domain\ValueObject\CreateOrderRequest;
use App\Clients\Domain\ValueObject\CreateClientRequest;
use App\Shared\Domain\ValueObject\CreateAddress;
use InvalidArgumentException;
use Nelmio\ApiDocBundle\Annotation\Model;
use Nelmio\ApiDocBundle\NelmioApiDocBundle;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class OrderController extends AbstractController
{
    /**
     * @param Request $request
     * @param OrderValidatorService $validator
     * @param OrderManager $orderManager
     * @return JsonResponse
     *
     * @Route("/create", name="create_order", methods={"POST"})
     *
     * @throws \Exception
     */
    public function create(
        Request $request,
        OrderValidatorService $validator,
        OrderManager $orderManager
    ): JsonResponse
    {
        $data = $request->request->all();

        try {
            $order = $orderManager->processOrder($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }

        return new JsonResponse(['orderId' => $order->getId()]);
    }

    /**
     * @param Request $request
     * @param OrderValidatorService $validator
     * @param OrderManager $orderManager
     * @return JsonResponse
     *
     * @Route("/add-tc-data", name="add_transport_company_data", methods={"PATCH"})
     */
    public function addTCData(
        Request $request,
        OrderValidatorService $validator,
        OrderManager $orderManager
    ): JsonResponse
    {
        $data = $request->request->all();

        try {
            $order = $orderManager->addTransportCompanyData($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }

        return new JsonResponse([
            'status' => 'ok',
            'orderId' => $order->getId(),
            'transportCompanyId' => $order->getTransportCompanyId(),
            'deliveryPrice' => $order->getDeliveryPrice()
        ]);
    }

    /**
     * @param Request $request
     * @param OrderManager $orderManager
     * @return JsonResponse
     *
     * @Route("/remove", name="remove_order", methods={"DELETE"})
     */
    public function remove(
        Request $request,
        OrderManager $orderManager
    ): JsonResponse
    {
        $data = $request->request->all();

        try {
            $order = $orderManager->removeOrder($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse(['error' => $e->getMessage()]);
        }

        return new JsonResponse([
            'status' => 'ok',
            'removedOrderId' => $order->getId()
        ]);
    }
}