<?php

namespace App\http\controllers;

use App\exceptions\InternalServerErrorException;
use App\exceptions\NotFoundException;
use App\exceptions\UnauthorizedTransferException;
use App\http\controllers\base\BaseController;
use App\http\requests\transfer\NewTransferRequest;
use App\http\responses\HttpResponse;
use App\services\transfer\MakeTransferService;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\ValidationException;

class TransferController extends BaseController
{
    private MakeTransferService $transferService;

    public function __construct(MakeTransferService $transferService)
    {
        $this->transferService = $transferService;
    }

    /**
     * @throws NotFoundException
     * @throws ValidationException
     * @throws InternalServerErrorException
     * @throws UnauthorizedTransferException
     */
    public function makeTransfer(NewTransferRequest $request): JsonResponse
    {
        $validatedParams = $request->validated();

        $newTransfer = $this->transferService->makeTransfer($validatedParams['value'], $validatedParams['payer'], $validatedParams['payee']);

        return HttpResponse::success(
            $newTransfer->toArray(),
            'Transfer completed successfully.',
            statusCode: 201);
    }
}
