<?php

namespace App\EventSubscriber;

use App\Api\ApiProblem;
use App\Exception\ApiProblemException;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpKernel\Event\ExceptionEvent;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\KernelEvents;

class HttpExceptionSubscriber implements EventSubscriberInterface
{
    public function onKernelException(ExceptionEvent $event): void
    {
        $e = $event->getThrowable();

        if (!$e instanceof HttpException) {
            return;
        }

        throw new ApiProblemException(
            new ApiProblem(422, ApiProblem::TYPE_ERROR, $e->getMessage())
        );
    }

    public static function getSubscribedEvents(): array
    {
        return [
            KernelEvents::EXCEPTION => 'onKernelException',
        ];
    }
}
