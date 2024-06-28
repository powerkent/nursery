<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Ramsey\Uuid\UuidInterface;

class Customer
{
    protected ?int $id = null;

    /** @var Collection<int, Child> */
    protected Collection $children;

    /**
     * @param array<int, Child>|Collection<int, Child>|null $children
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $firstname,
        protected string $lastname,
        protected string $email,
        array|Collection|null $children,
    ) {
        $this->children = is_array($children) ? new ArrayCollection($children) : $children;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUuid(): UuidInterface
    {
        return $this->uuid;
    }

    public function setUuid(UuidInterface $uuid): self
    {
        $this->uuid = $uuid;

        return $this;
    }

    public function getFirstname(): string
    {
        return $this->firstname;
    }

    public function setFirstname(string $firstname): self
    {
        $this->firstname = $firstname;

        return $this;
    }

    public function getLastname(): string
    {
        return $this->lastname;
    }

    public function setLastname(string $lastname): self
    {
        $this->lastname = $lastname;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;

        return $this;
    }

    /**
     * @return Collection<int, Child>|null
     */
    public function getChildren(): ?Collection
    {
        return $this->children;
    }

    /**
     * @param Collection<int, Child>|array<int, Child>|null $children
     */
    public function setChildren(Collection|array|null $children): self
    {
        $this->children = $children instanceof Collection ? $children : new ArrayCollection($children);

        return $this;
    }
}
