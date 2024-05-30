<?php

namespace App\database\sql\repositories;

use App\database\sql\entities\Transfer;
use App\database\sql\repositories\base\BaseRepository;
use Illuminate\Support\Facades\DB;

class TransferRepository extends BaseRepository
{
    public function findById(int $id): ?Transfer
    {
        $transfer = DB::select('SELECT * FROM tb_transfers WHERE id = :id LIMIT 1', ['id' => $id]);

        if (empty($transfer)) {
            return null;
        }

        return new Transfer($transfer[0]);
    }

    public function create(array $data): int
    {
        DB::insert(
            'INSERT INTO
                tb_transfers (
                    amount,
                    transfer_date,
                    id_sender,
                    id_receiver)
            VALUES (
                :amount,
                NOW(),
                :id_sender,
                :id_receiver)',
            [
                'amount' => $data['amount'],
                'id_sender' => $data['id_sender'],
                'id_receiver' => $data['id_receiver'],
            ]);

        return DB::getPdo()->lastInsertId();
    }
}
