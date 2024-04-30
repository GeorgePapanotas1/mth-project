<?php

namespace Mth\Common\Config\Dto;

class Config
{
    private mixed $value = null;

    public function getValue(): mixed
    {
        return $this->value;
    }

    public function setValue(mixed $value): self
    {
        $this->value = $value;

        return $this;
    }
}
