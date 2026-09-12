<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Payload;

use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

final class TrustedPersonPayload
{
    public function __construct(
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'TrustedPerson requires the lastname.')]
        public string $lastname,
        #[Groups(['family:item'])]
        #[Assert\NotBlank(message: 'TrustedPerson requires the firstname.')]
        public string $firstname,
        #[Groups(['family:item'])]
        public ?int $id = null,
    ) {
    }
}
