<?php

declare(strict_types=1);

namespace Nursery\Infrastructure\Shared\ApiPlatform\View\Child;

use Nursery\Domain\Shared\Model\Child;
use Nursery\Domain\Shared\Model\Treatment;
use Nursery\Infrastructure\Shared\ApiPlatform\View\IRP\IRPViewFactory;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment\TreatmentView;
use Nursery\Infrastructure\Shared\ApiPlatform\View\Treatment\TreatmentViewFactory;

final readonly class ChildViewFactory
{
    public function __construct(
        private IRPViewFactory $IRPViewFactory,
        private TreatmentViewFactory $treatmentViewFactory,
    ) {
    }

    public function fromModel(Child $child): ChildView
    {
        return new ChildView(
            uuid: $child->getUuid(),
            avatar: $child->getAvatar()?->getContentUrl(),
            firstname: $child->getFirstname(),
            lastname: $child->getLastname(),
            birthday: $child->getBirthday(),
            createdAt: $child->getCreatedAt(),
            irp: null !== $child->getIrp() ? $this->IRPViewFactory->fromModel($child->getIrp()) : null,
            treatments: $child->getTreatments()?->map(fn (Treatment $treatment): TreatmentView => $this->treatmentViewFactory->fromModel($treatment))->toArray(),
        );
    }
}
