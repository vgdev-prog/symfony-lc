<?php

declare(strict_types=1);

namespace App\Common\Infrastructure\Events;

use App\Common\Domain\Exception\AbstractDomainException;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\KernelEvents;

final readonly class DomainExceptionSubscriber implements EventSubscriberInterface
{

    public function __construct(
        private LoggerInterface $logger,
        private readonly string $environment,
    )
    {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => ['onKernelException', 10],
        ];
    }

    public function onKernelException(ExceptionEvent $event): void
    {
        $exception = $event->getThrowable();

        if (!$exception instanceof AbstractDomainException) {
            return;
        }

        $this->logger->warning('Domain exception occurred', [
            'code' => $exception::getDomainErrorCode(),
            'message' => $exception->getMessage(),
            'context' => $exception->getPublicContext(),
            'trace' => $exception->getTraceAsString(),
        ]);



        $responseData = [
            'error' => [
                'code' => $exception::getDomainErrorCode(),
                'message' => $exception->getMessage(),
            ],
        ];

        $context = $exception->getPublicContext();
        if (!empty($context)) {
            $responseData['error']['context'] = $context;
        }

        if ($this->environment === 'dev') {
            $responseData['error']['trace'] = array_slice($exception->getTrace(), 0, 10);
        }


        $response = new JsonResponse(
            $responseData,
            $exception::getStatusCode(),
            ['Content-Type' => 'application/json']
        );

        $event->setResponse($response);
    }
}
