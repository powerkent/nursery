<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use ApiPlatform\Metadata\ApiProperty;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class CustomerPayload
{
    public function __construct(
        #[Groups(['family:item'])]
        public ?string $uuid,
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'Customer requires a firstname.')]
        public string $firstname,
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'Customer requires a lastname.')]
        public string $lastname,
        #[Groups(['family:item'])]
        #[Assert\Email]
        #[ApiProperty(openapiContext: ['example' => 'parent@example.com'])]
        public string $email,
        #[Groups(['family:item'])]
        #[ApiProperty(openapiContext: ['example' => '+33606060606'])]
        public string $phoneNumber,
        #[Groups(['family:item'])]
        public ?float $income = null,
        #[Groups(['family:item'])]
        public ?AddressPayload $address = null,
    ) {
    }
}
