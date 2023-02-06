<?php

namespace App\Shared\Infrastructure\EventListener;

use InvalidArgumentException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;

class ExceptionListener
{
    public function __invoke(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();
        $status = 500;

        if ($exception instanceof InvalidArgumentException) {
            $status = 400;
        }

        $response = new JsonResponse([
            'error' => $exception->getMessage()
        ], $status);

        $event->setResponse($response);
    }

}