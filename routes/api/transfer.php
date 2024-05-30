<?php

use App\http\controllers\TransferController;
use Illuminate\Support\Facades\Route;

Route::post('/transfer', [TransferController::class, 'makeTransfer']);
