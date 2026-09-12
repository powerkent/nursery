<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Customer;

use DateTimeImmutable;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Domain\Shared\Repository\CustomerRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

final readonly class CreateOrUpdateCustomerCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private CustomerRepositoryInterface $customerRepository,
        private UserPasswordHasherInterface $passwordHasher,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateCustomerCommand $command): Customer
    {
        /** @var ?Customer $customer */
        $customer = $this->customerRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        $password = $command->primitives['password'];
        if (null !== $customer) {
            $family = $command->primitives['family'];
            unset($command->primitives['family']);
            $customer = $this->normalizer->denormalize($command->primitives, Customer::class, context: ['object_to_populate' => $customer, 'ignored_attributes' => ['password', 'address', 'avatar']]);
            $customer
                ->setPassword(null !== $password ? $this->passwordHasher->hashPassword($customer, $password) : null)
                ->setFamily($family)
                ->setUpdatedAt(new DateTimeImmutable())
                ->setAddress($command->primitives['address']);

            return $this->customerRepository->update($customer);
        }

        $command->primitives['avatar'] = null;
        $command->primitives['createdAt'] = new DateTimeImmutable();
        $customer = new Customer(...$command->primitives)
            ->setPassword(null !== $password ? $this->passwordHasher->hashPassword($customer, $password) : null)
            ->setFamily($command->primitives['family'])
            ->setAddress($command->primitives['address']);

        return $this->customerRepository->save($customer);
    }
}
