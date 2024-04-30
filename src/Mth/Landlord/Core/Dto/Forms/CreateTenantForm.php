<?php

namespace Mth\Landlord\Core\Dto\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class CreateTenantForm extends ArraySerializable
{
    private string $name;
    private string $domain;
    private string $database = 'tenant_';

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateTenantForm
    {
        $this->name = $name;

        return $this;
    }

    public function getDomain(): string
    {
        return $this->domain;
    }

    public function setDomain(string $domain): CreateTenantForm
    {
        $this->domain   = $domain;
        $this->database .= $domain;

        return $this;
    }

    public function getDatabase(): string
    {
        return $this->database;
    }

    public function serialize(): array
    {
        return $this->toDatabaseArray();
    }
}
