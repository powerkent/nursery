<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use Ramsey\Uuid\UuidInterface;

class TrustedPerson
{
    protected ?int $id = null;

    public function __construct(
        protected string $firstname,
        protected string $lastname,
        protected ?Family $family,
    ) {
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getFamily(): ?Family
    {
        return $this->family;
    }

    public function setFamily(?Family $family): self
    {
        $this->family = $family;

        return $this;
    }
}
