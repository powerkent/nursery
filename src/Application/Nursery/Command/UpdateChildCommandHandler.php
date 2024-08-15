<?php

declare(strict_types=1);

namespace Nursery\Application\Nursery\Command;

use Doctrine\ORM\EntityNotFoundException;
use Nursery\Domain\Nursery\Model\Child;
use Nursery\Domain\Nursery\Model\IRP;
use Nursery\Domain\Nursery\Repository\ChildRepositoryInterface;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Ramsey\Uuid\UuidInterface;

final class UpdateChildCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private ChildRepositoryInterface $childRepository,
    ) {
    }

    public function __invoke(UpdateChildCommand $command): Child
    {
        dump($command);
        /** @var ?Child $child */
        $child = $command->id() instanceof UuidInterface ? $this->childRepository->searchByUuid($command->id()) : $this->childRepository->search($command->id());

        if (null === $child) {
            throw new EntityNotFoundException(Child::class);
        }

        if (!empty($command->primitives['irp'])) {
            $child->setIrp(new IRP(...$command->primitives['irp']));
        }

        if (!empty($child->getTreatments())) {
            foreach ($child->getTreatments() as $existingTreatment) {
                $child->removeTreatment($existingTreatment);
            }
        }

        foreach ($command->primitives['treatments'] as $treatment) {
            $child->addTreatment($treatment);
        }

        return $this->childRepository->update($child);
    }
}
