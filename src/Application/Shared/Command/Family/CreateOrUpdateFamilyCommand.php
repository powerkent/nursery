<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use Nursery\Domain\Shared\Command\AbstractCreateCommand;
use Nursery\Domain\Shared\Command\CommandInterface;

final class CreateOrUpdateFamilyCommand implements CommandInterface
{
    public function __construct(public array $primitives, public array $trustedPersons)
    {
    }
}
