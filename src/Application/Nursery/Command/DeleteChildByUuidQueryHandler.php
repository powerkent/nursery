<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Doctrine\ORM\EntityNotFoundException;
use Nursery\Domain\Nursery\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Ramsey\Uuid\Uuid;

final readonly class DeleteChildByUuidQueryHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
    ) {
    }

    public function __invoke(DeleteChildByUuidQuery $command): bool
    {
        $child = $this->childRepository->searchByUuid(is_string($command->uuid) ? Uuid::fromString($command->uuid) : $command->uuid);

        if (null === $child) {
            throw new EntityNotFoundException(sprintf('unable to find the child you want to delete. uuid : %s', $command->uuid));
        }

        $this->childRepository->delete($child);

        return true;
    }
}
