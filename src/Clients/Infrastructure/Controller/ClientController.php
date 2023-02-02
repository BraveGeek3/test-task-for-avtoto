<?php

namespace App\Clients\Infrastructure\Controller;

use App\Clients\Domain\Entity\Client;
use App\Clients\Domain\Factory\ClientFactory;
use App\Clients\Domain\Repository\ClientRepositoryInterface;
use App\Clients\Infrastructure\Repository\ClientRepository;
use App\Clients\Infrastructure\Service\Manager\ClientManagerService;
use Doctrine\ORM\EntityManagerInterface;
use InvalidArgumentException;
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
     */
    public function create(
        Request $request,
        ClientManagerService $clientManager
    ): JsonResponse
    {
        $data = $request->request->all();

        try {
            $client = $clientManager->createClient($data);
        } catch (InvalidArgumentException $e) {
            return new JsonResponse([
                'error' => $e->getMessage()
            ], 400);
        }

        return new JsonResponse([
            'clientId' => $client->getId(),
        ], 201);
    }

}