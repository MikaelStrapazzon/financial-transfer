<?php

namespace App\database\sql\entities;

use App\database\sql\entities\base\BaseEntity;
use App\database\sql\entities\enums\UserType;

class User extends BaseEntity
{
    public int $id;

    public string $name;

    public string $email;

    public string $password;

    public string $cpf_cnpj;

    public float $balance;

    public UserType $type;

    public function __construct($data)
    {
        $this->id = $data->id ?? 0;
        $this->name = $data->name ?? null;
        $this->email = $data->email ?? null;
        $this->password = $data->password ?? null;
        $this->cpf_cnpj = $data->cpf_cnpj ?? null;
        $this->balance = $data->balance ?? null;
        $this->type = UserType::from($data->type);
    }
}
