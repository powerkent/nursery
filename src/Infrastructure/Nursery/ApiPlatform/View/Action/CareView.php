<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Nursery\ApiPlatform\View\Action;

use Nursery\Domain\Nursery\Enum\CareType;
use Symfony\Component\Serializer\Annotation\Groups;

class CareView
{
    /**
     * @param list<CareType> $careTypes
     */
    public function __construct(
        #[Groups(['action:item', 'action:list'])]
        /** @var list<CareType> $careTypes */
        public array $careTypes,
    ) {
    }
}
