<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\TrustedPerson;
use Nursery\Infrastructure\Shared\Foundry\Factory\TrustedPersonFactory;

class TrustedPersonFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        TrustedPersonFactory::createMany(40);
    }

    protected static function modelClass(): string
    {
        return TrustedPerson::class;
    }

    public function getDependencies(): array
    {
        return [
            FamilyFixtures::class,
        ];
    }
}
