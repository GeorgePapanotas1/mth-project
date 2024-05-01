<?php

namespace Mth\Tenant\Core\Dto\Authorization\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class CreateRoleForm extends ArraySerializable
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateRoleForm
    {
        $this->name = $name;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toFullArray();
    }
}
