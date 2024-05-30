<?php

namespace App\database\sql\entities\base;

abstract class BaseEntity
{
    public function toArray(): array
    {
        return get_object_vars($this);
    }
}
