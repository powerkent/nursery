<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Family
{
    protected ?int $id = null;

    /** @var Collection<int, Child> */
    protected Collection $children;

    /** @var Collection<int, TrustedPerson> */
    protected Collection $trustedPersons;

    /**
     * @param array<int, Child>|Collection<int, Child>                 $children
     * @param array<int, TrustedPerson>|Collection<int, TrustedPerson> $trustedPersons
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $name,
        protected ?Customer $customerA,
        protected ?Customer $customerB,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
        protected ?string $comment = null,
        protected ?string $internalComment = null,
        array|Collection $children = [],
        array|Collection $trustedPersons = []
    ) {
        $this->children = is_array($children) ? new ArrayCollection($children) : $children;
        $this->trustedPersons = is_array($trustedPersons) ? new ArrayCollection($trustedPersons) : $trustedPersons;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getUpdatedAt(): ?DateTimeInterface
    {
        return $this->updatedAt;
    }

    public function setUpdatedAt(?DateTimeInterface $updatedAt): self
    {
        $this->updatedAt = $updatedAt;

        return $this;
    }

    public function getCustomerA(): ?Customer
    {
        return $this->customerA;
    }

    public function setCustomerA(?Customer $customerA): self
    {
        $this->customerA = $customerA;
        if (null !== $customerA && $customerA->getFamily() !== $this) {
            $customerA->setFamily($this);
        }

        return $this;
    }

    public function getCustomerB(): ?Customer
    {
        return $this->customerB;
    }

    public function setCustomerB(?Customer $customerB): self
    {
        $this->customerB = $customerB;
        if (null !== $customerB && $customerB->getFamily() !== $this) {
            $customerB->setFamily($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Child>
     */
    public function getChildren(): Collection
    {
        return $this->children;
    }

    public function addChild(Child $child): self
    {
        if (!$this->children->contains($child)) {
            $this->children->add($child);
        }

        return $this;
    }

    public function removeChild(Child $child): self
    {
        $this->children->removeElement($child);

        return $this;
    }

    /**
     * @return Collection<int, TrustedPerson>
     */
    public function getTrustedPersons(): Collection
    {
        return $this->trustedPersons;
    }

    public function setTrustedPersons(array|Collection $trustedPersons): self
    {
        $this->trustedPersons = is_array($trustedPersons) ? new ArrayCollection($trustedPersons) : $trustedPersons;

        return $this;
    }

    public function addTrustedPerson(TrustedPerson $person): self
    {
        if (!$this->trustedPersons->contains($person)) {
            $this->trustedPersons->add($person);
        }

        return $this;
    }

    public function removeTrustedPerson(TrustedPerson $person): self
    {
        $this->trustedPersons->removeElement($person);

        return $this;
    }

    public function getComment(): ?string
    {
        return $this->comment;
    }

    public function setComment(?string $comment): self
    {
        $this->comment = $comment;

        return $this;
    }

    public function getInternalComment(): ?string
    {
        return $this->internalComment;
    }

    public function setInternalComment(?string $internalComment): self
    {
        $this->internalComment = $internalComment;

        return $this;
    }
}
