<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('tb_transfers', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10);
            $table->dateTime('transfer_date');
            $table->unsignedBigInteger('id_sender');
            $table
                ->foreign('id_sender')
                ->references('id')
                ->on('tb_users');
            $table->unsignedBigInteger('id_receiver');
            $table
                ->foreign('id_receiver')
                ->references('id')
                ->on('tb_users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tb_transfers');
    }
};
