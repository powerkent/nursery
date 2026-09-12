<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;

final class CreateOrUpdateTrustedPersonCommand extends AbstractCreateCommand
{
    public static function create(array $primitives): CreateOrUpdateTrustedPersonCommand
    {
        return new self($primitives);
    }
}
