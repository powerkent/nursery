<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Factory;
use Nursery\Domain\Shared\Enum\AvatarType;
use Nursery\Domain\Shared\Enum\Gender;
use Nursery\Domain\Shared\Model\Child;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Child>
 *
 * @codeCoverageIgnore
 */
final class ChildFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Child::class;
    }

    /**
     * @return array<string, mixed>
     */
    protected function defaults(): array
    {
        $faker = Factory::create();
        $faker->addProvider(new CustomImageProvider($faker));

        $firstname = self::faker()->firstName();
        $lastname = self::faker()->lastName();

        return [
            'uuid' => Uuid::uuid4(),
            'avatar' => AvatarFactory::createOne(['type' => AvatarType::Child, 'contentUrl' => $faker->imageUrl($firstname, $lastname)]),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'birthday' => DateTimeImmutable::createFromMutable(self::faker()->dateTime()),
            'gender' => Gender::tryFrom(self::faker()->randomElement(['Male', 'Female'])),
            'nurseryStructure' => NurseryStructureFactory::randomOrCreate(),
            'ageGroup' => AgeGroupFactory::randomOrCreate(),
            'isWalking' => self::faker()->boolean(),
            'family' => FamilyFactory::randomOrCreate(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')) : null,
            'irp' => self::faker()->boolean() ? IRPFactory::createOne() : null,
            'treatments' => [],
            'contractDates' => [],
        ];
    }
}
