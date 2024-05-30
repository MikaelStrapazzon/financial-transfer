<?php

namespace App\database\sql\entities;

use App\database\sql\entities\base\baseEntity;
use DateTime;

class Transfer extends BaseEntity
{
    public int $id;

    public float $amount;

    public ?DateTime $transfer_date;

    public int $id_sender;

    public int $id_receiver;

    public function __construct($data)
    {
        $this->id = $data->id ?? null;
        $this->amount = $data->amount ?? null;
        $this->id_sender = $data->id_sender ?? null;
        $this->id_receiver = $data->id_receiver ?? null;

        if (! empty($data->transfer_date)) {
            try {
                $this->transfer_date = new DateTime($data->transfer_date);
            } catch (\Exception $e) {
            }
        }
    }
}
