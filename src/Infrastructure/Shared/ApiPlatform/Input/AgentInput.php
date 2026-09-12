<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Domain\Shared\Processor\AgentInputInterface;
use Symfony\Component\Serializer\Annotation\Groups;

final class AgentInput implements AgentInputInterface
{
    /**
     * @param list<string>                      $roles
     * @param array<int, NurseryStructure>|null $nurseryStructures
     */
    public function __construct(
        #[Groups(['agent:item'])]
        public string $firstname,
        #[Groups(['agent:item'])]
        public string $lastname,
        #[Groups(['agent:item'])]
        #[ApiProperty(openapiContext: ['example' => 'agent@example.com'])]
        public string $email,
        #[Groups(['agent:item'])]
        public ?string $user,
        #[Groups(['agent:item'])]
        public ?string $password,
        #[Groups(['agent:item'])]
        #[ApiProperty(openapiContext: [
            'type' => 'array',
            'items' => [
                'type' => 'string',
                'enum' => ['ROLE_MANAGER', 'ROLE_AGENT'],
            ],
            'example' => ['ROLE_AGENT'],
        ])]
        /** @var list<string> $roles */
        public array $roles,
        #[Groups(['agent:item'])]
        #[ApiProperty(openapiContext: [
            'type' => 'array',
            'items' => [
                'type' => 'string',
            ],
            'example' => ['2ee90540-d853-41ed-9dc4-799877efa81d', '9fe9aecb-dbf2-4672-932d-c59b0e586e04'],
        ])]
        /** @var list<string> $nurseryStructures */
        public ?array $nurseryStructures,
    ) {
    }
}
