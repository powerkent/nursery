<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Address;

use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Address;
use Nursery\Domain\Shared\Repository\AddressRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;

final readonly class CreateOrUpdateAddressCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private AddressRepositoryInterface $addressRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateAddressCommand $command): Address
    {
        if (null !== $command->primitives['id']) {
            /** @var ?Address $address */
            $address = $this->addressRepository->search((int) $command->primitives['id']);

            if (null !== $address) {
                $address = $this->normalizer->denormalize($command->primitives, Address::class, context: ['object_to_populate' => $address, 'ignored_attributes' => ['id']]);

                return $this->addressRepository->update($address);
            }
        }

        unset($command->primitives['id']);
        $address = new Address(...$command->primitives);

        return $this->addressRepository->save($address);
    }
}
