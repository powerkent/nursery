<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Processor\Agent;

use DateTimeImmutable;
use Nursery\Application\Shared\Command\Agent\CreateOrUpdateAgentCommand;
use Nursery\Domain\Shared\Command\CommandBusInterface;
use Nursery\Domain\Shared\Model\Agent;
use Nursery\Domain\Shared\Processor\AgentProcessorInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Input\AgentInput;
use Ramsey\Uuid\UuidInterface;

final readonly class AgentProcessor implements AgentProcessorInterface
{
    public function __construct(
        private CommandBusInterface $commandBus,
    ) {
    }

    /**
     * @param AgentInput $data
     */
    public function process($data, UuidInterface $uuid): Agent
    {
        $primitives = [
            'uuid' => $uuid,
            'firstname' => $data->firstname,
            'lastname' => $data->lastname,
            'email' => $data->email,
            'createdAt' => new DateTimeImmutable(),
            'updatedAt' => new DateTimeImmutable(),
            'user' => $data?->user,
            'password' => $data?->password,
            'nurseryStructures' => $data->nurseryStructures,
            'roles' => $data->roles,
        ];

        return $this->commandBus->dispatch(CreateOrUpdateAgentCommand::create($primitives));
    }
}
