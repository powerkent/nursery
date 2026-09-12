<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\ContractDate;
use Nursery\Infrastructure\Shared\Foundry\Factory\ContractDateFactory;

class ContractDateFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ContractDateFactory::createMany(30);
    }

    protected static function modelClass(): string
    {
        return ContractDate::class;
    }

    public function getDependencies(): array
    {
        return [
            ChildFixtures::class,
        ];
    }
}
