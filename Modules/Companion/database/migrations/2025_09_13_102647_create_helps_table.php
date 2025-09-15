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
            $table->foreignId('companion_id')->constrained('companions')->onDelete('cascade');
            $table->enum('type', ['cash', 'objects']);
            $table->string('name');
            $table->string('national_code');
            $table->boolean('status_payment')->nullable();
            $table->string('mobile');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('helps');
    }
};
