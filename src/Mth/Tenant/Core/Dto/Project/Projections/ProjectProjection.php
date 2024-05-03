<?php

namespace Mth\Tenant\Core\Dto\Project\Projections;

use Mth\Common\Core\Utils\ArraySerializable;

class ProjectProjection extends ArraySerializable
{
    private string $id;
    private string $name;
    private string $description;
    private string $creator;
    private string $company;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): ProjectProjection
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): ProjectProjection
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): ProjectProjection
    {
        $this->description = $description;

        return $this;
    }

    public function getCreator(): string
    {
        return $this->creator;
    }

    public function setCreator(string $creator): ProjectProjection
    {
        $this->creator = $creator;

        return $this;
    }

    public function getCompany(): string
    {
        return $this->company;
    }

    public function setCompany(string $company): ProjectProjection
    {
        $this->company = $company;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toCleanArray();
    }
}
