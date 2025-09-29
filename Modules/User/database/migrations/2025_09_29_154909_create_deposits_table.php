<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Modules\User\App\Models\Deposit;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('deposits', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companion_id')->constrained('companions')->cascadeOnDelete();
            $table->unsignedBigInteger('amount');
            $table->foreignId('transaction_id')->nullable()->constrained('transactions');
            $table->enum('status',Deposit::getAvailableStatus());
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('deposits');
    }
};
