<?php

namespace App\Warehouses\Infrastructure\Controller;

use App\Warehouses\Infrastructure\Service\Manager\WarehouseManager;
use App\Warehouses\Infrastructure\Service\Validator\WarehouseValidatorService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class WarehouseController extends AbstractController
{
    /**
     * @param Request $request
     * @param WarehouseValidatorService $validator
     * @param WarehouseManager $warehouseManager
     * @return JsonResponse
     *
     * @Route("/create", name="create_warehouse", methods={"POST"})
     */
    public function create(
        Request $request,
        WarehouseManager $warehouseManager
    ): JsonResponse
    {
        $data = $request->request->all();

        try {
            $warehouse = $warehouseManager->addWarehouse($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }


        return new JsonResponse([
            'warehouseId' => $warehouse->getId(),
        ]);
    }

    /**
     * @param Request $request
     * @param WarehouseManager $warehouseManager
     * @return JsonResponse
     *
     * @Route("/get-info", name="get_warehouse_info", methods={"GET"})
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

//        if (($warehouse = $warehouseManager->showInfo($data['warehouseId'])) === null) {
//            return new JsonResponse([
//                'error' => 'Provide correct warehouse id'
//            ]);
//        }

        try {
            $warehouse = $warehouseManager->showInfo($data['warehouseId']);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }

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
     */
    public function remove(
        Request $request,
        WarehouseManager $warehouseManager
    ): JsonResponse
    {
        $data = $request->request->all();
//        if (!isset($data['warehouseId'])) {
//            return new JsonResponse([]);
//        }

        try {
            $warehouseId = $warehouseManager->removeWarehouse($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }

//        if (($warehouse = $warehouseManager->removeWarehouse($data['warehouseId'])) === null) {
//            return new JsonResponse([
//                'error' => 'Provide correct warehouse id'
//            ]);
//        }

        return new JsonResponse([
            'status' => 'ok',
            'warehouseId' => $warehouseId
        ]);
    }
}