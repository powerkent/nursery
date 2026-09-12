<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use Nursery\Domain\Shared\Model\TrustedPerson;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<TrustedPerson>
 *
 * @codeCoverageIgnore
 */
final class TrustedPersonFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return TrustedPerson::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        return [
            'firstname' => self::faker()->firstName(),
            'lastname' => self::faker()->lastName(),
            'family' => FamilyFactory::random(),
        ];
    }
}
