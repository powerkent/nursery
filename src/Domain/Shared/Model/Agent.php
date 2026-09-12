<?php

declare(strict_types=1);

namespace Nursery\Domain\Shared\Model;

use DateTimeInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use LogicException;
use Nursery\Domain\Shared\Enum\Roles;
use Nursery\Domain\Shared\User\UserDomainInterface;
use Ramsey\Uuid\UuidInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Webmozart\Assert\Assert;
use function is_array;

class Agent implements UserDomainInterface, PasswordAuthenticatedUserInterface
{
    protected ?int $id = null;

    /**
     * @ORM\Column(type="json")
     * @var array<int, string>
     */
    public array $roles;

    /** @var Collection<int, NurseryStructure> */
    protected Collection $nurseryStructures;

    /** @var Collection<int, ClockingIn> */
    protected Collection $clockIns;

    /** @var Collection<int, AgentSchedule> */
    protected Collection $schedules;

    /**
     * @param array<int, string>                                             $roles
     * @param array<int, NurseryStructure>|Collection<int, NurseryStructure> $nurseryStructures
     * @param array<int, ClockingIn>|Collection<int, ClockingIn>             $clockIns
     * @param array<int, AgentSchedule>|Collection<int, AgentSchedule>       $schedules
     */
    public function __construct(
        protected UuidInterface $uuid,
        protected ?Avatar $avatar,
        protected string $firstname,
        protected string $lastname,
        protected string $email,
        protected DateTimeInterface $createdAt,
        protected ?DateTimeInterface $updatedAt,
        protected ?string $user,
        protected ?string $password = null,
        array|Collection $nurseryStructures = [],
        array $roles = [],
        array|Collection $clockIns = [],
        array|Collection $schedules = [],
    ) {
        Assert::stringNotEmpty($firstname, 'Firstname cannot be empty.');
        Assert::stringNotEmpty($lastname, 'Lastname cannot be empty.');
        Assert::email($email, 'Invalid email address.');

        $this->roles = $roles;
        if (empty($this->roles)) {
            $this->roles = [Roles::Agent->value];
        }

        $this->nurseryStructures = is_array($nurseryStructures) ? new ArrayCollection($nurseryStructures) : $nurseryStructures;
        $this->clockIns = is_array($clockIns) ? new ArrayCollection($clockIns) : $clockIns;
        $this->schedules = is_array($schedules) ? new ArrayCollection($schedules) : $schedules;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function setId(?int $id): self
    {
        $this->id = $id;

        return $this;
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

    public function getAvatar(): ?Avatar
    {
        return $this->avatar;
    }

    public function setAvatar(?Avatar $avatar): self
    {
        $this->avatar = $avatar;

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

    /**
     * @return Collection<int, NurseryStructure>
     */
    public function getNurseryStructures(): Collection
    {
        return $this->nurseryStructures;
    }

    /**
     * @param Collection<int, NurseryStructure> $nurseryStructures
     */
    public function setNurseryStructures(Collection $nurseryStructures): self
    {
        $this->nurseryStructures = $nurseryStructures;

        return $this;
    }

    public function addNurseryStructure(NurseryStructure $nurseryStructure): self
    {
        if (!$this->nurseryStructures->contains($nurseryStructure)) {
            $this->nurseryStructures->add($nurseryStructure);
        }

        return $this;
    }

    /**
     * @return array<int, string>
     */
    public function getRoles(): array
    {
        return $this->roles;
    }

    /**
     * @param array<int, string> $roles
     */
    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    public function getUser(): ?string
    {
        return $this->user;
    }

    public function setUser(?string $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        if (empty($this->user)) {
            throw new LogicException('User identifier cannot be empty.');
        }

        return $this->user;
    }

    public function getSalt(): ?string
    {
        return null;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $hashedPassword): self
    {
        $this->password = $hashedPassword;

        return $this;
    }

    /**
     * @return Collection<int, ClockingIn>
     */
    public function getClockIns(): Collection
    {
        return $this->clockIns;
    }

    /**
     * @param Collection<int, ClockingIn> $clockIns
     */
    public function setClockIns(Collection $clockIns): self
    {
        $this->clockIns = $clockIns;

        return $this;
    }

    /**
     * @return Collection<int, AgentSchedule>
     */
    public function getSchedules(): Collection
    {
        return $this->schedules;
    }

    /**
     * @param Collection<int, AgentSchedule> $schedules
     */
    public function setSchedules(Collection $schedules): self
    {
        $this->schedules = $schedules;

        return $this;
    }

    public function addSchedule(AgentSchedule $agentSchedule): self
    {
        if (!$this->schedules->contains($agentSchedule)) {
            $this->schedules->add($agentSchedule);
        }

        return $this;
    }
}
