<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Fixtures;

use Doctrine\Common\DataFixtures\DependentFixtureInterface;
use Doctrine\Persistence\ObjectManager;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Infrastructure\Shared\Foundry\Factory\ChildFactory;

class ChildFixtures extends AbstractFixtures implements DependentFixtureInterface
{
    public function load(ObjectManager $manager): void
    {
        ChildFactory::createMany(30);
    }

    protected static function modelClass(): string
    {
        return Child::class;
    }

    public function getDependencies(): array
    {
        return [
            NurseryStructureFixtures::class,
            IRPFixtures::class,
            FamilyFixtures::class,
            CustomerFixtures::class,
        ];
    }
}
