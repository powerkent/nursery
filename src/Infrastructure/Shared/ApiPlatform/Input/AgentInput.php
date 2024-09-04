<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Input;

use ApiPlatform\Metadata\ApiProperty;
use Nursery\Domain\Shared\Model\NurseryStructure;
use Nursery\Infrastructure\Shared\ApiPlatform\Payload\NurseryStructurePayload;
use Symfony\Component\Serializer\Annotation\Groups;

final class AgentInput
{
    /**
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
        public string $password,
        #[Groups(['agent:item'])]
        /** @var list<NurseryStructurePayload> $nurseryStructures */
        public ?array $nurseryStructures,
    ) {
    }
}
