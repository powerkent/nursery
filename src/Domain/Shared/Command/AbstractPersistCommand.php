<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Command;

abstract class AbstractPersistCommand implements CommandInterface
{
    /**
     * @param array<string, mixed> $primitives
     */
    protected function __construct(public array $primitives)
    {
    }
}
