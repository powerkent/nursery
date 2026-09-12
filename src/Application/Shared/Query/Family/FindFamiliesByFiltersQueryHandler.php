<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Query\Family;

use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Query\QueryHandlerInterface;
use Nursery\Domain\Shared\Repository\FamilyRepositoryInterface;

final readonly class FindFamiliesByFiltersQueryHandler implements QueryHandlerInterface
{
    public function __construct(private FamilyRepositoryInterface $familyRepository)
    {
    }

    /**
     * @return array<int, Family>
     */
    public function __invoke(FindFamiliesByFiltersQuery $query): array
    {
        if (empty($query->filters)) {
            return $this->familyRepository->all();
        }

        return $this->familyRepository->searchByNurseryStructures($query->filters['nurseryStructures']);
    }
}
