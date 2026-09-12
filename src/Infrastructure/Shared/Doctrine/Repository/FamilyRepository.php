<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\Doctrine\Repository;

use Doctrine\Common\Collections\ArrayCollection;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Model\TrustedPerson;
use Nursery\Domain\Shared\Repository\FamilyRepositoryInterface;

/**
 * @extends AbstractRepository<Family>
 */
class FamilyRepository extends AbstractRepository implements FamilyRepositoryInterface
{
    protected static function entityClass(): string
    {
        return Family::class;
    }

    public function searchByNurseryStructures(array $nurseryStructures): array
    {
        return $this->createQueryBuilder('f')
            ->join('f.children', 'c')
            ->join('c.nurseryStructure', 'ns')
            ->where('ns.uuid IN (:uuids)')
            ->setParameter('uuids', implode(',', $nurseryStructures))
            ->getQuery()
            ->getResult();
    }
}
