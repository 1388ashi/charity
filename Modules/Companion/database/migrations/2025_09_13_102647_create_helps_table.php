<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('helps', function (Blueprint $table) {
            $table->id();
            $table->foreignId('companion_id')->nullable()->constrained('companions')->onDelete('cascade');
            $table->foreignId('help_user_id')->constrained('help_users')->onDelete('cascade');
            $table->enum('type', ['cash', 'objects']);
            $table->string('amount')->nullable();
            $table->boolean('status_payment')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('helps');
    }
};
