<?php

namespace Mth\Tenant\Core\Dto\Project\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class UpdateProjectForm extends ArraySerializable
{
    private string $id;
    private ?string $name = null;
    private ?string $description = null;
    private ?string $creatorId = null;
    private ?string $companyId = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): UpdateProjectForm
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): UpdateProjectForm
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): UpdateProjectForm
    {
        $this->description = $description;

        return $this;
    }

    public function getCreatorId(): ?string
    {
        return $this->creatorId;
    }

    public function setCreatorId(?string $creatorId): UpdateProjectForm
    {
        $this->creatorId = $creatorId;

        return $this;
    }

    public function getCompanyId(): ?string
    {
        return $this->companyId;
    }

    public function setCompanyId(?string $companyId): UpdateProjectForm
    {
        $this->companyId = $companyId;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toDatabaseArray();
    }
}
