<?php

namespace App\Products\Infrastructure\Controller;

use App\Products\Infrastructure\Service\Manager\ProductManagerService;
use App\Products\Infrastructure\Service\Validator\ProductValidatorService;
use InvalidArgumentException;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ProductController extends AbstractController
{
    /**
     * @param Request $request
     * @param ProductValidatorService $validator
     * @param ProductManagerService $productManager
     * @return JsonResponse
     *
     * @Route("/create", name="create_product", methods={"POST"})
     */
    public function create(
        Request $request,
        ProductValidatorService $validator,
        ProductManagerService $productManager

    ): JsonResponse
    {
        $data = $request->request->all();

        if (!$validator->validate($data)) {
            return new JsonResponse(["Invalid data"], 400);
        }

        try {
            $product = $productManager->addProduct($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }

        return new JsonResponse([
            'productId' => $product->getId()
        ]);
    }
}