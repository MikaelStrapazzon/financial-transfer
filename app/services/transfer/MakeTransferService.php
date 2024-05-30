<?php

namespace App\services\transfer;

use App\database\sql\entities\enums\UserType;
use App\database\sql\entities\Transfer;
use App\Database\sql\entities\User;
use App\database\sql\repositories\TransferRepository;
use App\exceptions\InternalServerErrorException;
use App\exceptions\NotFoundException;
use App\services\user\UserCrudService;
use Exception;
use Illuminate\Validation\ValidationException;

class MakeTransferService
{
    private TransferCrudService $transferCrudService;

    private UserCrudService $userCrudService;

    private TransferRepository $transferRepository;

    public function __construct()
    {
        $this->transferCrudService = new TransferCrudService();
        $this->userCrudService = new UserCrudService();

        $this->transferRepository = new TransferRepository();
    }

    /**
     * Process a financial transfer between users.
     *
     * @throws ValidationException
     * @throws InternalServerErrorException
     * @throws NotFoundException
     */
    public function makeTransfer(float $value, int $payerId, int $payeeId): Transfer
    {
        if ($value <= 0.01) {
            throw ValidationException::withMessages(['value' => 'The transfer value cannot be less than 0.01']);
        }

        if ($payerId === $payeeId) {
            throw ValidationException::withMessages(['payee' => 'The payee must be different from the payer.']);
        }

        $payer = $this->userCrudService->findById($payerId);
        $this->validTransferPayer($payer, $value);

        $payee = $this->userCrudService->findById($payeeId);

        return $this->executeTransaction($value, $payer, $payee);
    }

    /**
     * @throws InternalServerErrorException
     */
    private function executeTransaction(float $value, User $payer, User $payee): Transfer
    {
        $this->transferRepository->beginTransaction();

        try {
            $payer->balance -= $value;
            $this->userCrudService->update($payer);

            $payee->balance += $value;
            $this->userCrudService->update($payee);

            $newTransfer = $this->transferCrudService->create([
                'amount' => $value,
                'id_sender' => $payer->id,
                'id_receiver' => $payee->id,
            ]);

            $this->transferRepository->commit();

            return $newTransfer;
        } catch (Exception) {
            $this->transferRepository->rollback();
            throw new InternalServerErrorException(
                "Something didn't go as expected, transfer not carried out"
            );
        }
    }

    /**
     * @throws ValidationException
     */
    private function validTransferPayer(User $payer, float $value): void
    {
        if ($payer->balance < $value) {
            throw ValidationException::withMessages(['payee' => 'The selected payee does not have sufficient balance.']);
        }

        if ($payer->type !== UserType::INDIVIDUAL) {
            throw ValidationException::withMessages(['payee' => 'The selected payee must be an individual.']);
        }
    }
}
