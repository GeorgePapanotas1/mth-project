<?php

namespace Mth\Tenant\Core\Dto\User\Forms;

use Carbon\Carbon;
use Mth\Common\Core\Utils\ArraySerializable;

class UpdateUserForm extends ArraySerializable
{
    private string $id;
    private ?string $name = null;
    private ?string $email = null;
    private ?string $password = null;

    public function getId(): string
    {
        return $this->id;
    }

    public function setId(string $id): UpdateUserForm
    {
        $this->id = $id;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): UpdateUserForm
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): UpdateUserForm
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(?string $password): UpdateUserForm
    {
        $this->password = $password;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toDatabaseArray();
    }
}
