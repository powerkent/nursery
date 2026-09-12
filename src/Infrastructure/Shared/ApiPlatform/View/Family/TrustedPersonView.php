<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Family;

use Symfony\Component\Serializer\Annotation\Groups;

class TrustedPersonView
{
    public function __construct(
        #[Groups(['family:item', 'family:list'])]
        public ?int $id,
        #[Groups(['family:item', 'family:list'])]
        public string $firstname,
        #[Groups(['family:item', 'family:list'])]
        public string $lastname,
    ) {
    }
}
