<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Factory;

use DateTimeImmutable;
use Faker\Factory;
use libphonenumber\PhoneNumberFormat;
use libphonenumber\PhoneNumberUtil;
use Nursery\Domain\Shared\Enum\AvatarType;
use Nursery\Domain\Shared\Model\Customer;
use Nursery\Infrastructure\Shared\Foundry\Provider\CustomImageProvider;
use Ramsey\Uuid\Uuid;
use Zenstruck\Foundry\Persistence\PersistentProxyObjectFactory;

/**
 * @extends PersistentProxyObjectFactory<Customer>
 *
 * @codeCoverageIgnore
 */
final class CustomerFactory extends PersistentProxyObjectFactory
{
    public static function class(): string
    {
        return Customer::class;
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

        $phoneUtil = PhoneNumberUtil::getInstance();
        $parsedNumber = $phoneUtil->parse(self::faker()->phoneNumber(), 'FR');
        $formattedNumber = $phoneUtil->format($parsedNumber, PhoneNumberFormat::E164);

        return [
            'uuid' => Uuid::uuid4(),
            'avatar' => AvatarFactory::createOne(['type' => AvatarType::Customer, 'contentUrl' => $faker->imageUrl($firstname, $lastname)]),
            'firstname' => $firstname,
            'lastname' => $lastname,
            'email' => self::faker()->email(),
            'user' => self::faker()->name(),
            'password' => self::faker()->password(),
            'phoneNumber' => $formattedNumber,
            'family' => FamilyFactory::randomOrCreate(),
            'address' => AddressFactory::createOne(),
            'createdAt' => DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')),
            'updatedAt' => self::faker()->boolean() ? DateTimeImmutable::createFromMutable(self::faker()->dateTimeBetween('-5 days')) : null,
            'roles' => [],
        ];
    }
}
