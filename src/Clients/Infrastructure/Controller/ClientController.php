<?php

namespace App\Clients\Infrastructure\Controller;

use App\Clients\Domain\ValueObject\CreateClientRequest;
use App\Clients\Infrastructure\Service\Manager\ClientManagerService;
use Doctrine\ORM\EntityManagerInterface;
use Nelmio\ApiDocBundle\Annotation\Model;
use OpenApi\Annotations as OA;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class ClientController extends AbstractController
{

    /**
     * @param Request $request
     * @param EntityManagerInterface $em
     * @return JsonResponse
     *
     * @Route("/create", name="create_client", methods={"POST"})
     * @OA\RequestBody(
     *     required=true,
     *     @OA\MediaType(
     *         mediaType="application/x-www-form-urlencoded",
     *         @OA\Schema(
     *             ref=@Model(type=CreateClientRequest::class)
     *         )
     *    )
     *)
     * @OA\Response(
     *     response="201",
     *     description="Returns client id",
     *     @OA\JsonContent(
     *         @OA\Property(type="string", property="clientId")
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
        ClientManagerService $clientManager
    ): JsonResponse
    {
        $data = $request->request->all();

        $client = $clientManager->createClient($data);

        return new JsonResponse([
            'clientId' => $client->getId(),
        ], 201);
    }

}