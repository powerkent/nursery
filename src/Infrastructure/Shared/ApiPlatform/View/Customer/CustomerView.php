<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Customer;

use DateTimeInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Address\AddressView;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class CustomerView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public UuidInterface $uuid,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public ?string $avatar,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public string $firstname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public string $lastname,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public ?string $email,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public string $phoneNumber,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public ?float $income,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public ?AddressView $address,
        #[Groups(['child:item', 'child:list', 'customer:item', 'family:item', 'family:list'])]
        public DateTimeInterface $createdAt,
    ) {
    }
}
