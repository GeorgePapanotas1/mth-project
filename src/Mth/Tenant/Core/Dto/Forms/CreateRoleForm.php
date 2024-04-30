<?php

namespace Mth\Tenant\Core\Dto\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class CreateRoleForm extends ArraySerializable
{
    private string $name;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function serialize(): array
    {
        return $this->toFullArray();
    }
}
