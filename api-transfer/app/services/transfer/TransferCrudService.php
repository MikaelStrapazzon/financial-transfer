<?php

namespace App\services\transfer;

use App\database\sql\entities\Transfer;
use App\database\sql\repositories\TransferRepository;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\ValidationException;

class TransferCrudService
{
    private TransferRepository $transferRepository;

    public function __construct()
    {
        $this->transferRepository = new TransferRepository();
    }

    /**
     * @throws ValidationException
     */
    public function create(array $transfer): Transfer
    {
        $validatedDataTransfer = $this->validateTransfer($transfer, 'create');

        $idTransfer = $this->transferRepository->create($validatedDataTransfer);

        return $this->transferRepository->findById($idTransfer);
    }

    /**
     * @throws ValidationException
     */
    private function validateTransfer(Transfer|array $transfer, string $context): array
    {
        if ($transfer instanceof Transfer) {
            $transfer = [
                'amount' => $transfer->amount,
                'transfer_date' => $transfer->transfer_date?->format('Y-m-d H:i:s'),
                'id_sender' => $transfer->id_sender,
                'id_receiver' => $transfer->id_receiver,
            ];
        }

        $rules = [
            'amount' => 'required|numeric|min:0.01|max:9999999.99',
            'id_sender' => 'required|integer',
            'id_receiver' => 'required|integer|different:id_sender',
        ];

        if ($context === 'update') {
            $rules['transfer_date'] = 'required|date';
        }

        $validator = Validator::make($transfer, $rules);
        $validator->validate();

        return $validator->validated();
    }
}
