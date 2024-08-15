<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\Provider;

use ApiPlatform\Metadata\Operation;
use Nursery\Application\Shared\Query\FindActionByUuidQuery;
use Nursery\Domain\Shared\Model\AbstractAction;
use Nursery\Domain\Shared\Query\QueryBusInterface;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Action\ActionResource;
use Nursery\Infrastructure\Shared\ApiPlatform\Resource\Action\ActionResourceFactory;

/**
 * @extends AbstractProvider<AbstractAction, ActionResource>
 */
final class ActionProvider extends AbstractProvider
{
    public function __construct(
        private readonly QueryBusInterface $queryBus,
        private readonly ActionResourceFactory $actionResourceFactory,
    ) {
    }

    protected function item(Operation $operation, array $uriVariables = [], array $context = []): ?AbstractAction
    {
        dump($action = $this->queryBus->ask(new FindActionByUuidQuery(uuid: $uriVariables['uuid'])));

        return $action;
    }

    /**
     * @param AbstractAction $model
     *
     * @return ActionResource
     */
    protected function toResource(object $model): object
    {
        return $this->actionResourceFactory->fromModel($model);
    }
}
