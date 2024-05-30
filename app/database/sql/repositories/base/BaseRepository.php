<?php

namespace App\database\sql\repositories\base;

use Illuminate\Support\Facades\DB;

abstract class BaseRepository
{
    public function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    public function commit(): void
    {
        DB::commit();
    }

    public function rollback(): void
    {
        DB::rollback();
    }
}
