<?php

namespace App\Warehouses\Infrastructure\Controller;

use App\Warehouses\Infrastructure\Service\Manager\WarehouseManager;
use App\Shared\Domain\ValueObject\CreateAddress;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WarehouseController extends AbstractController
{
    /**
     * @param Request $request
     * @param WarehouseManager $warehouseManager
     * @return JsonResponse
     *
     * @Route("/create", name="create_warehouse", methods={"POST"})
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *             ref=@Model(type=CreateAddress::class)
     *         )
     *    )
     * )
     * @OA\Response(
     *     response="200",
     *     description="Returns order updated fields",
     *     @OA\JsonContent(
     *         @OA\Property(property="orderId", type="string")
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
    public function create(
        Request $request,
        WarehouseManager $warehouseManager
    ): JsonResponse
    {
        $data = $request->request->all();

        $warehouse = $warehouseManager->addWarehouse($data);

        return new JsonResponse([
            'warehouseId' => $warehouse->getId(),
        ], 201);
    }

    /**
     * @param Request $request
     * @param WarehouseManager $warehouseManager
     * @return JsonResponse
     *
     * @Route("/get-info", name="get_warehouse_info", methods={"GET"})
     * @OA\Parameter(
     *     name="warehouseId",
     *     in="query",
     *     description="Warehouse id to get info",
     *     required=true,
     *     @OA\Property(type="string", property="warehouseId")
     * )
     * @OA\Response(
     *     response="200",
     *     description="Returns warehouse id, address id and products info",
     *     @OA\JsonContent(
     *         type="object",
     *         @OA\Property(type="string", property="removedOrderId"),
     *         @OA\Property(type="string", property="addressId"),
     *         @OA\Property(
     *             type="array",
     *             property="products",
     *             @OA\Items(
     *                 type="object",
     *                 @OA\Property(type="string", property="id"),
     *                 @OA\Property(type="integer", property="availableCount")
     *             )
     *         )
     *     )
     * )
     * )
     * @OA\Response(
     *     response="400",
     *     description="Invalid credentials",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="error")
     *     )
     * )
     */
    public function getInfo(
        Request $request,
        WarehouseManager $warehouseManager
    ): JsonResponse
    {
        $data = $request->query->all();
        if (!isset($data['warehouseId'])) {
            return new JsonResponse([]);
        }

        $warehouse = $warehouseManager->showInfo($data['warehouseId']);

        $address = $warehouse->getAddress();

        $productData = [];
        foreach ($warehouse->getProducts()->toArray() as $product) {
            $productData[] = [
                'id' => $product->getId(),
                'availableCount' => $product->getAvailableCount()
            ];
        }

        return new JsonResponse([
            'warehouseId' => $warehouse->getId(),
            'addressId' => $address->getId(),
            'products' => $productData
        ]);
    }

    /**
     * @param Request $request
     * @param WarehouseManager $warehouseManager
     * @return JsonResponse
     *
     * @Route("/remove", name="remove_warehouse", methods={"DELETE"})
     * @OA\RequestBody(
     *     required=true,
     *     description="Requires order id",
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *             @OA\Property(
     *             type="string",
     *             property="warehouseId"
     *             )
     *         )
     *    )
     * )
     * @OA\Response(
     *     response="200",
     *     description="Returns removed order id",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="removedWarehouseId")
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
        WarehouseManager $warehouseManager
    ): JsonResponse
    {
        $data = $request->request->all();

        $warehouseId = $warehouseManager->removeWarehouse($data);

        return new JsonResponse([
            'removedWarehouseId' => $warehouseId
        ]);
    }
}