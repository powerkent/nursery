<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Symfony\Messenger\Middleware;

use Symfony\Component\Messenger\Envelope;
use Symfony\Component\Messenger\Exception\HandlerFailedException;
use Symfony\Component\Messenger\Exception\UnrecoverableMessageHandlingException;
use Symfony\Component\Messenger\Middleware\MiddlewareInterface;
use Symfony\Component\Messenger\Middleware\StackInterface;
use Throwable;

final class ExceptionConverterMiddleware implements MiddlewareInterface
{
    public function handle(Envelope $envelope, StackInterface $stack): Envelope
    {
        try {
            return $stack->next()->handle($envelope, $stack);
        } catch (Throwable $e) {
            $e = new UnrecoverableMessageHandlingException($e->getMessage(), $e->getCode(), $e);

            if ($e instanceof HandlerFailedException) {
                $e = new HandlerFailedException($e->getEnvelope(), [$e]);
            }

            throw $e;
        }
    }
}
