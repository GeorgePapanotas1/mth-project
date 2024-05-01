<?php

namespace Mth\Tenant\Core\Dto\User\Forms;

use Mth\Common\Core\Utils\ArraySerializable;

class CreateUserForm extends ArraySerializable
{
    private string $name;
    private string $email;
    private string $password;

    public function getName(): string
    {
        return $this->name;
    }

    public function setName(string $name): CreateUserForm
    {
        $this->name = $name;

        return $this;
    }

    public function getEmail(): string
    {
        return $this->email;
    }

    public function setEmail(string $email): CreateUserForm
    {
        $this->email = $email;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): CreateUserForm
    {
        $this->password = $password;

        return $this;
    }

    public function serialize(): array
    {
        return $this->toDatabaseArray();
    }
}
