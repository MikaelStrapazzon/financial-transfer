<?php

namespace App\database\sql\repositories;

use App\database\sql\entities\User;
use App\database\sql\repositories\base\BaseRepository;
use Illuminate\Support\Facades\DB;

class UserRepository extends BaseRepository
{
    public function findById(int $id): ?User
    {
        $user = DB::select('SELECT * FROM tb_users WHERE id = :id LIMIT 1', ['id' => $id]);

        if (empty($user)) {
            return null;
        }

        return new User($user[0]);
    }

    public function update(User $user)
    {
        // TODO

        return DB::update(
            'UPDATE tb_users SET balance = :balance WHERE id = :id',
            [
                'id' => $user->id,
                'balance' => $user->balance,
            ]
        );
    }
}
