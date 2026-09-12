<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Customer;

use Nursery\Domain\Shared\Model\Customer;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Address\AddressViewFactory;

final readonly class CustomerViewFactory
{
    public function __construct(
        private AddressViewFactory $addressViewFactory,
    ) {
    }

    public function fromModel(Customer $customer): CustomerView
    {
        return new CustomerView(
            uuid: $customer->getUuid(),
            avatar: $customer->getAvatar()?->getContentUrl(),
            firstname: $customer->getFirstname(),
            lastname: $customer->getLastname(),
            email: $customer->getEmail(),
            phoneNumber: $customer->getPhoneNumber(),
            income: $customer->getIncome(),
            createdAt: $customer->getCreatedAt(),
            address: null !== $customer->getAddress() ? $this->addressViewFactory->fromModel($customer->getAddress()) : null,
        );
    }
}
