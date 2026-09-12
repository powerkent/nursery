<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\TrustedPerson;
use Nursery\Domain\Shared\Repository\TrustedPersonRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;

final readonly class CreateOrUpdateTrustedPersonCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private TrustedPersonRepositoryInterface $trustedPersonRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateTrustedPersonCommand $command): TrustedPerson
    {
        if (null !== $command->primitives['id']) {
            /** @var ?TrustedPerson $trustedPerson */
            $trustedPerson = $this->trustedPersonRepository->search((int) $command->primitives['id']);

            if (null !== $trustedPerson) {
                $trustedPerson = $this->normalizer->denormalize($command->primitives, TrustedPerson::class, context: ['object_to_populate' => $trustedPerson, 'ignored_attributes' => ['id']]);

                return $this->trustedPersonRepository->update($trustedPerson);
            }
        }

        unset($command->primitives['id']);
        $trustedPerson = new TrustedPerson(...$command->primitives);

        return $this->trustedPersonRepository->save($trustedPerson);
    }
}
