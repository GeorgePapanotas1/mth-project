<?php

namespace Mth\Tenant\Core\Dto\Company\Projections;

use Mth\Common\Core\Utils\ArraySerializable;

class CompanyProjection extends ArraySerializable
{
    private string $id;
    private string $name;
    private string $address;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): CompanyProjection
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CompanyProjection
    {
        $this->name = $name;

        return $this;
    }

    public function getAddress(): string
    {
        return $this->address;
    }

    public function setAddress(string $address): CompanyProjection
    {
        $this->address = $address;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toCleanArray();
    }
}
