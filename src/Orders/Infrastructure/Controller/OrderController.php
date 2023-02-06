<?php

namespace App\Orders\Infrastructure\Controller;

use App\Orders\Infrastructure\Service\Manager\OrderManager;
use App\Orders\Infrastructure\Service\Validator\OrderValidatorService;
use App\Orders\Domain\ValueObject\TCDataRequest;
use Nelmio\ApiDocBundle\Annotation\Model;
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
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *             type="object",
     *             @OA\Property(
     *                 property="products",
     *                 type="array",
     *                 @OA\Items(
     *                     type="object",
     *                     @OA\Property(property="id", type="string"),
     *                     @OA\Property(property="count", type="integer")
     *                 )
     *             ),
     *             @OA\Property(property="client[phoneNumber]",type="string"),
     *             @OA\Property(property="client[email]", type="string"),
     *             @OA\Property(property="client[firstName]", type="string"),
     *             @OA\Property(property="client[lastName]", type="string"),
     *             @OA\Property(property="client[patronymic]", type="string", nullable=true),
     *             @OA\Property(property="address[region]", type="string"),
     *             @OA\Property(property="address[city]", type="string"),
     *             @OA\Property(property="address[street]", type="string"),
     *             @OA\Property(property="address[buildingNumber]", type="string"),
     *             )
     *         )
     *     )
     * )
     * @OA\Response(
     *     response="201",
     *     description="Returns client id",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="orderId")
     *     )
     * )
     *
     * @OA\Response(
     *     response="400",
     *     description="Invalid credentials",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="error")
     *     )
     * )
     *
     * @throws \Exception
     */
    public function create(
        Request $request,
        OrderManager $orderManager
    ): JsonResponse
    {
        $data = $request->request->all();

        $order = $orderManager->processOrder($data);

        return new JsonResponse([
            'orderId' => $order->getId()
        ], 201);
    }

    /**
     * @param Request $request
     * @param OrderValidatorService $validator
     * @param OrderManager $orderManager
     * @return JsonResponse
     *
     * @Route("/add-tc-data", name="add_transport_company_data", methods={"PATCH"})
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *             ref=@Model(type=TCDataRequest::class)
     *         )
     *    )
     *)
     * @OA\Response(
     *     response="200",
     *     description="Returns order updated fields",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(property="orderId", type="string"),
     *         @OA\Property(property="transportCompanyId", type="string"),
     *         @OA\Property(property="deliveryPrice", type="float"),
     *     )
     * )
     * @OA\Response(
     *     response="400",
     *     description="Invalid credentials",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="error")
     *     )
     * )
     */
    public function addTCData(
        Request $request,
        OrderValidatorService $validator,
        OrderManager $orderManager
    ): JsonResponse
    {
        $data = $request->request->all();

        $order = $orderManager->addTransportCompanyData($data);

        return new JsonResponse([
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
     * @OA\RequestBody(
     *     required=true,
     *     description="Requires order id",
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *             @OA\Property(
     *             type="string",
     *             property="orderId"
     *             )
     *         )
     *    )
     * )
     * @OA\Response(
     *     response="200",
     *     description="Returns removed order id",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="removedOrderId")
     *     )
     * )
     * @OA\Response(
     *     response="400",
     *     description="Invalid credentials",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="error")
     *     )
     * )
     */
    public function remove(
        Request $request,
        OrderManager $orderManager
    ): JsonResponse
    {
        $data = $request->request->all();

        $order = $orderManager->removeOrder($data);

        return new JsonResponse([
            'removedOrderId' => $order->getId()
        ]);
    }
}