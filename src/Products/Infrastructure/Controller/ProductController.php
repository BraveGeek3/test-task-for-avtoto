<?php

namespace App\Products\Infrastructure\Controller;

use App\Products\Infrastructure\Service\Manager\ProductManagerService;
use App\Products\Infrastructure\Service\Validator\ProductValidatorService;
use App\Products\Domain\ValueObject\CreateProductRequest;
use InvalidArgumentException;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
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
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *             ref=@Model(type=CreateProductRequest::class)
     *         )
     *    )
     * )
     * @OA\Response(
     *     response="200",
     *     description="Returns client id",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="productId")
     *     )
     * )
     * @OA\Response(
     *     response="400",
     *     description="Invalid credentials",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="error")
     *     )
     * )
     *
     */
    public function create(
        Request $request,
        ProductManagerService $productManager

    ): JsonResponse
    {
        $data = $request->request->all();

        $product = $productManager->addProduct($data);

        return new JsonResponse([
            'productId' => $product->getId()
        ], 201);
    }
}