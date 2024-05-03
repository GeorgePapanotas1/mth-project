<?php

namespace Mth\Tenant\Core\Dto\User\Projections;

use Mth\Common\Core\Utils\ArraySerializable;
use Mth\Tenant\Core\Dto\Company\Projections\CompanyProjection;

class UserProjection extends ArraySerializable
{
    private string $id;
    private string $email;
    private string $name;
    private bool $isAdmin;
    private string $role;
    /* @var CompanyProjection[]|null */
    private ?array $companies = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): UserProjection
    {
        $this->id = $id;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): UserProjection
    {
        $this->email = $email;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): UserProjection
    {
        $this->name = $name;

        return $this;
    }

    public function isAdmin(): bool
    {
        return $this->isAdmin;
    }

    public function setIsAdmin(bool $isAdmin): UserProjection
    {
        $this->isAdmin = $isAdmin;

        return $this;
    }

    public function getRole(): string
    {
        return $this->role;
    }

    public function setRole(string $role): UserProjection
    {
        $this->role = $role;

        return $this;
    }

    public function getCompanies(): ?array
    {
        return $this->companies;
    }

    public function setCompanies(?array $companies): UserProjection
    {
        $this->companies = $companies;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toCleanArray();
    }
}
