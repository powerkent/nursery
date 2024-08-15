<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Action;

use DateTimeInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class ActivityView
{
    public function __construct(
        #[Groups(['action:item'])]
        public UuidInterface $uuid,
        #[Groups(['action:item'])]
        public string $name,
        #[Groups(['action:item'])]
        public ?string $description,
        #[Groups(['action:item'])]
        public ?string $comment,
        #[Groups(['action:item'])]
        public DateTimeInterface $createdAt,
    ) {
    }
}
