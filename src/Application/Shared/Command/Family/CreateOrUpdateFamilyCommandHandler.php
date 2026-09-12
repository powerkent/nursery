<?php

declare(strict_types=1);

namespace Nursery\Application\Shared\Command\Family;

use DateTimeImmutable;
use Nursery\Domain\Shared\Command\CommandHandlerInterface;
use Nursery\Domain\Shared\Model\Family;
use Nursery\Domain\Shared\Model\TrustedPerson;
use Nursery\Domain\Shared\Repository\FamilyRepositoryInterface;
use Nursery\Domain\Shared\Serializer\NormalizerInterface;
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\UuidInterface;

final readonly class CreateOrUpdateFamilyCommandHandler implements CommandHandlerInterface
{
    public function __construct(
        private FamilyRepositoryInterface $familyRepository,
        private NormalizerInterface $normalizer,
    ) {
    }

    public function __invoke(CreateOrUpdateFamilyCommand $command): Family
    {
        /** @var ?Family $family */
        $family = $this->familyRepository->searchByUuid(!$command->primitives['uuid'] instanceof UuidInterface ? Uuid::fromString($command->primitives['uuid']) : $command->primitives['uuid']);

        if (null !== $family) {
            $family = $this->normalizer->denormalize($command->primitives, Family::class, context: ['object_to_populate' => $family, 'ignored_attributes' => ['customerA', 'customerB', 'createdAt', 'updatedAt']]);
            $family
                ->setUpdatedAt(new DateTimeImmutable());

            return $this->familyRepository->update($this->updateTrustedPersons($family, $command->trustedPersons));
        }

        $command->primitives['createdAt'] = new DateTimeImmutable();
        $family = new Family(...$command->primitives);

        return $this->familyRepository->save($this->updateTrustedPersons($family, $command->trustedPersons));
    }

    private function updateTrustedPersons(Family $family, array $trustedPersonsData): Family
    {
        $current = $family->getTrustedPersons();

        $idsInPayload = [];
        foreach ($trustedPersonsData as $tpData) {
            if (!empty($tpData['id'])) {
                $idsInPayload[] = (int) $tpData['id'];
            }
        }

        foreach ($current as $existingTp) {
            if (!in_array($existingTp->getId(), $idsInPayload, true)) {
                $family->removeTrustedPerson($existingTp);
            }
        }

        foreach ($trustedPersonsData as $tpData) {
            $tp = null;
            if (!empty($tpData['id'])) {
                foreach ($current as $existingTp) {
                    if ($existingTp->getId() === (int) $tpData['id']) {
                        $tp = $existingTp;
                        break;
                    }
                }
            }
            if (!$tp) {
                $tp = new TrustedPerson($tpData['firstname'], $tpData['lastname'], $family);
                $family->addTrustedPerson($tp);
            }
            $tp->setFirstname($tpData['firstname'])
                ->setLastname($tpData['lastname'])
                ->setFamily($family);
        }

        return $family;
    }
}
