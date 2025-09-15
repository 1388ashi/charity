<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('amount');
            $table->string('type');
            $table->string('transaction_id')->nullable();
            $table->string('status')->default('pending');
            $table->text('status_detail')->nullable();
            $table->unsignedBigInteger('wallet_amount')->default(0);
            $table->foreignId('payable_id');
            $table->string('payable_type');
            $table->timestamps();
            
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
