<?php

namespace Mth\Tenant\Core\Dto\Company\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class CreateCompanyForm extends ArraySerializable
{
    private string $name;
    private string $address;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateCompanyForm
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): CreateCompanyForm
    {
        $this->address = $address;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toDatabaseArray();
    }
}
