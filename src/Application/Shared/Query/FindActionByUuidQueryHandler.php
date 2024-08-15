<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query;

use Nursery\Domain\Shared\Model\AbstractAction;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\AbstractActionRepositoryInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class FindActionByUuidQueryHandler implements QueryHandlerInterface
{
    public function __construct(private AbstractActionRepositoryInterface $actionRepository)
    {
    }

    final public function __invoke(FindActionByUuidQuery $query): ?AbstractAction
    {
        $action = $this->actionRepository->searchByUuid(!$query->uuid instanceof UuidInterface ? Uuid::fromString($query->uuid) : $query->uuid);
        dump($action);

        return $action;
    }
}
