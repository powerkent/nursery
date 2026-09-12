<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Family;

use Nursery\Domain\Shared\Model\TrustedPerson;

final class TrustedPersonViewFactory
{
    public function fromModel(TrustedPerson $trustedPerson): TrustedPersonView
    {
        return new TrustedPersonView(
            id: $trustedPerson->getId(),
            firstname: $trustedPerson->getFirstname(),
            lastname: $trustedPerson->getLastname(),
        );
    }
}
