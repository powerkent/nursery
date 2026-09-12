<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Foundry\Provider;

use Faker\Generator;
use Faker\Provider\Base;

class CustomImageProvider extends Base
{
    private const array BACKGROUND_COLORS = [
        'A8DADC',
        'FFC1C1',
        'FAD7A0',
        'A3C9A8',
        'E8998D',
        'F7DC6F',
        'B5EAD7',
        'C3B1E1',
        'AEDFF7',
        'B3CDE0',
        'F4A896',
        'FAD4C0',
        'C5E1A5',
        'B2EBF2',
        'D7BDE2',
        'F5B7B1',
        'FAE3B8',
        'B9FBC0',
    ];

    public function __construct(Generator $generator)
    {
        parent::__construct($generator);
    }

    public function imageUrl(string $firstname = 'John', string $lastname = 'Doe'): string
    {
        $background = self::BACKGROUND_COLORS[self::numberBetween(0, count(self::BACKGROUND_COLORS) - 1)];

        return "https://ui-avatars.com/api/?name=$firstname+$lastname&background=$background";
    }
}
