<?php

namespace Mth\Tenant\Core\Dto\Project\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class CreateProjectForm extends ArraySerializable
{
    private string $name;
    private string $description;
    private string $creatorId;
    private string $companyId;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateProjectForm
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    public function setDescription(string $description): CreateProjectForm
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatorId(): string
    {
        return $this->creatorId;
    }

    public function setCreatorId(string $creatorId): CreateProjectForm
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    public function getCompanyId(): string
    {
        return $this->companyId;
    }

    public function setCompanyId(string $companyId): CreateProjectForm
    {
        $this->companyId = $companyId;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toDatabaseArray();
    }
}
