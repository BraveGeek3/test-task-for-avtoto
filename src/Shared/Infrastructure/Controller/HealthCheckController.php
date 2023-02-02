<?php

namespace App\Shared\Infrastructure\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\Routing\Annotation\Route;

class HealthCheckController extends AbstractController
{
    /**
     * @return JsonResponse
     * @Route("/", name="health_check")
     */
    public function healthCheck(): JsonResponse
    {
        return new JsonResponse([
            'status' => 'ok'
        ]);
    }

}