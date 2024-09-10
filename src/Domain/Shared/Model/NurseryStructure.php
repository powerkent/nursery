<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Nursery\Domain\Shared\Enum\OpeningDays;
use Ramsey\Uuid\UuidInterface;
use Webmozart\Assert\Assert;

class NurseryStructure
{
    protected ?int $id = null;

    /** @var Collection<int, Agent> */
    protected Collection $agents;

    /**
     * @param array<int, Agent>|Collection<int, Agent> $agents
     * @param list<OpeningDays>                        $openingDays
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected string $name,
        protected string $address,
        protected DateTimeInterface $openingHour,
        protected DateTimeInterface $closingHour,
        protected array $openingDays,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt = null,
        protected ?DateTimeInterface $startAt = null,
        array|Collection $agents = [],
    ) {
        Assert::stringNotEmpty($this->name);
        Assert::stringNotEmpty($this->address);

        $this->agents = is_array($agents) ? new ArrayCollection($agents) : $agents;
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

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): self
    {
        $this->address = $address;

        return $this;
    }

    public function getOpeningHour(): DateTimeInterface
    {
        return $this->openingHour;
    }

    public function setOpeningHour(DateTimeInterface $openingHour): self
    {
        $this->openingHour = $openingHour;

        return $this;
    }

    public function getClosingHour(): DateTimeInterface
    {
        return $this->closingHour;
    }

    public function setClosingHour(DateTimeInterface $closingHour): self
    {
        $this->closingHour = $closingHour;

        return $this;
    }

    /**
     * @return list<OpeningDays>
     */
    public function getOpeningDays(): array
    {
        return $this->openingDays;
    }

    /**
     * @param list<OpeningDays> $openingDays
     */
    public function setOpeningDays(array $openingDays): self
    {
        $this->openingDays = $openingDays;

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

    public function getStartAt(): ?DateTimeInterface
    {
        return $this->startAt;
    }

    public function setStartAt(?DateTimeInterface $startAt): self
    {
        $this->startAt = $startAt;

        return $this;
    }

    /**
     * @return Collection<int, Agent>
     */
    public function getAgents(): Collection
    {
        return $this->agents;
    }

    /**
     * @param array<int, Agent>|Collection<int, Agent> $agents
     */
    public function setNurseryStructures(Collection|array $agents): self
    {
        $this->agents = $agents instanceof Collection ? $agents : new ArrayCollection($agents);

        return $this;
    }

    public function addAgent(Agent $agent): self
    {
        if (!$this->agents->contains($agent)) {
            $this->agents->add($agent);
        }

        return $this;
    }

    public function removeAgent(Agent $agent): self
    {
        if ($this->agents->contains($agent)) {
            $this->agents->removeElement($agent);
        }

        return $this;
    }
}
