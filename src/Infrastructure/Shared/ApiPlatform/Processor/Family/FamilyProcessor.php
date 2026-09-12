<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Family;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use DateTimeImmutable;
use Nursery\Application\Shared\Command\Address\CreateOrUpdateAddressCommand;
use Nursery\Application\Shared\Command\Customer\CreateOrUpdateCustomerCommand;
use Nursery\Application\Shared\Command\Family\CreateOrUpdateFamilyCommand;
use Nursery\Application\Shared\Command\Family\CreateOrUpdateTrustedPersonCommand;
use Nursery\Application\Shared\Command\Family\PersistFamilyCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Model\Address;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\FamilyInput;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family\FamilyResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Family\FamilyResourceFactory;
use Ramsey\Uuid\Uuid;

/**
 * @implements ProcessorInterface<FamilyInput, FamilyResource>
 */
final readonly class FamilyProcessor implements ProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
        private FamilyResourceFactory $familyResourceFactory,
    ) {
    }

    /**
     * @param FamilyInput $data
     */
    public function process($data, Operation $operation, array $uriVariables = [], array $context = []): FamilyResource
    {
        $address = $this->commandBus->dispatch(CreateOrUpdateAddressCommand::create([
            'id' => $data->customerA->address->id,
            'address' => $data->customerA->address->address,
            'zipcode' => $data->customerA->address->zipcode,
            'city' => $data->customerA->address->city,
        ]));

        /** @var Customer $customerA */
        $customerA = $this->commandBus->dispatch(CreateOrUpdateCustomerCommand::create($this->createCustomerPrimitives($data, $address, true)));
        $customerB = null;
        if (null !== $data->customerB) {
            if (!$data->isSameAddress) {
                $address = $this->commandBus->dispatch(CreateOrUpdateAddressCommand::create([
                    'id' => $data->customerB->address->id,
                    'address' => $data->customerB->address->address,
                    'zipcode' => $data->customerB->address->zipcode,
                    'city' => $data->customerB->address->city,
                ]));
            }

            $customerB = $this->commandBus->dispatch(CreateOrUpdateCustomerCommand::create($this->createCustomerPrimitives($data, $address, false)));
        }

        $primitives = [
            'uuid' => $uriVariables['uuid'] ?? Uuid::uuid4(),
            'name' => $data->name,
            'customerA' => $customerA,
            'customerB' => $customerB,
            'createdAt' => new DateTimeImmutable(),
            'updatedAt' => null,
            'comment' => null,
            'internalComment' => $data->internalComment,
        ];

        $family = $this->commandBus->dispatch(new CreateOrUpdateFamilyCommand($primitives, array_map(fn($tp) => (array) $tp, $data->trustedPersons)));

        return $this->familyResourceFactory->fromModel($family);
    }

    /**
     * @return array<string, mixed>
     */
    private function createCustomerPrimitives(FamilyInput $data, Address $address, bool $isFirstCustomer): array
    {
        $uuid = $isFirstCustomer
            ? ($data->customerA->uuid ?? Uuid::uuid4())
            : ($data->customerB->uuid ?? Uuid::uuid4());

        return [
            'uuid' => $uuid,
            'avatar' => null,
            'firstname' => !$isFirstCustomer && null !== $data->customerB ? $data->customerB->firstname : $data->customerA->firstname,
            'lastname' => !$isFirstCustomer && null !== $data->customerB ? $data->customerB->lastname : $data->customerA->lastname,
            'email' => !$isFirstCustomer && null !== $data->customerB ? $data->customerB->email : $data->customerA->email,
            'user' => null,
            'password' => null,
            'phoneNumber' => !$isFirstCustomer && null !== $data->customerB ? $data->customerB->phoneNumber : $data->customerA->phoneNumber,
            'family' => null,
            'address' => $address,
            'income' => !$isFirstCustomer && null !== $data->customerB ? $data->customerB->income : $data->customerA->income,
            'internalComment' => null,
        ];
    }
}
