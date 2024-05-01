<?php

namespace Mth\Tenant\Core\Dto\Company\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class UpdateCompanyForm extends ArraySerializable
{
    private string $id;
    private ?string $name = null;
    private ?string $address = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): UpdateCompanyForm
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): UpdateCompanyForm
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->address;
    }

    public function setAddress(?string $address): UpdateCompanyForm
    {
        $this->address = $address;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toDatabaseArray();
    }
}
