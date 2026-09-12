<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\IRP;

use DateTimeInterface;
use Symfony\Component\Serializer\Annotation\Groups;

class IRPView
{
    public function __construct(
        #[Groups(['child:item', 'child:list', 'customer:item', 'nurseryStructure:item'])]
        public string $name,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public string $description,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $createdAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public DateTimeInterface $startAt,
        #[Groups(['child:item', 'child:list', 'customer:item'])]
        public ?DateTimeInterface $endAt,
    ) {
    }
}
